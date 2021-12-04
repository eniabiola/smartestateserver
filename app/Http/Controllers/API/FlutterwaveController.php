<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Mail\GeneralMail;
use App\Mail\UserWelcomeMail;
use App\Models\Transaction;
use App\Models\OldWallet;
use App\Models\WalletFundingTransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class FlutterwaveController extends AppBaseController
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    public function initialize(Request $request)
    {
        $this->validate($request, [
           'amount' => 'required|numeric'
        ]);
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $request->amount,
            'email' => request()->user()->email,
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('api.callback'),
            'customer' => [
                'email' => request()->user()->email,
                "phone_number" => request()->user()->phone,
                "name" => request()->user()->surname
            ],

            "customizations" => [
                "title" => 'Wallet Funding',
                "description" => date("Y-m-d H:i:s")
            ]
        ];

        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            \Log::debug(print_r($payment, true));
            return $this->sendError("An error occurred", 400);
        }

        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->estate_id = Auth::user()->estate_id;
        $transaction->description = "wallet Funding ".date("Y-m-d H:i:s");
        $transaction->amount = $request->amount;
        $transaction->gateway_commission = 0.00;
        $transaction->total_amount = $request->amount;
        $transaction->transaction_type = "debit";
        $transaction->transaction_status = "initiated";
        $transaction->transaction_reference = $reference;
        $transaction->date_initiated = date("Y-m-d H:i:s");
        $transaction->save();

            return $this->sendResponse($payment['data']['link'], "Redirect to Payment Link");
    }


    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback(Request $request)
    {
        $status = request()->status;
        $reference = $request->tx_ref;
        $transactionID = $request->transaction_id;
        $transaction = Transaction::where('transaction_reference', $reference)->first();
        if (!$transaction) return $this->sendError("Unknown Transaction.");

        $checkTransaction = WalletFundingTransactionLog::query()
            ->where('transaction_id', $transactionID)
            ->where('status', $status)
            ->first();
        if ($checkTransaction) return $this->sendError("This transaction has been processed", 400);

        if ($status ==  'successful') {
            $transactionID = $request->transaction_id;
            $secret_key = config('flutterwave.secretKey');
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$transactionID."/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer ".$secret_key
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $checkTransaction = WalletFundingTransactionLog::query()
                ->where('transaction_id', $transactionID)
                ->where('status', $status)
                ->first();
            if ($checkTransaction) return $this->sendError("This transaction has been processed", 400);

            WalletFundingTransactionLog::create([
                'transaction_id' => $transactionID,
                'transaction_reference' => $reference,
                'status' => $status,
                'response' => $response
            ]);
            $decoded_data = json_decode($response, true);

            $transaction->amount = $decoded_data['data']['amount_settled'];
            $transaction->gateway_commission = $decoded_data['data']['app_fee'];
            $transaction->total_amount = $decoded_data['data']['charged_amount'];
            $transaction->transaction_status = "successful";
            $message = "Wallet Successfully Funded.";
            $status = true;


            $wallet = OldWallet::query()->where('user_id', request()->user()->id)->first();

            if($wallet)
            {
                $walletPrev_balance = $wallet->prev_balance;
            } else {
                $wallet = new OldWallet();
                $walletPrev_balance = 0.00;
            }
            $wallet->user_id = request()->user()->id;
            $wallet->prev_balance = $walletPrev_balance;
            $wallet->amount = $decoded_data['data']['amount_settled'];
            $wallet->current_balance = $walletPrev_balance + $decoded_data['data']['amount_settled'];
            $wallet->transaction_type = 'credit';
            $wallet->save();
        }
        elseif ($status ==  'cancelled'){
            $transaction->transaction_status = "cancelled";
            $message = "User cancelled the transaction";
            $status = false;
        }
        else{
            $transaction->transacton_status = "failed";
            $message = "The transaction failed";
            $status = false;
        }
        $transaction->save();

        if ($status === false)
        {
            return $this->sendError($message);
        }

        $details = [
            "subject" => "Wallet Funding",
            "name" => Auth::user()->surname. " ".Auth::user()->othernames,
            "message" => "Your wallet has been funded with {$wallet->amount} <br> and your new wallet balance is {$wallet->current_balance}",
        ];

        $email = new GeneralMail($details);
        Mail::to(Auth::user()->email)->queue($email);

        return $this->sendSuccess($message);
    }


}
