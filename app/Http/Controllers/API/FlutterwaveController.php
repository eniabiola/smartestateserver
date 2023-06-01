<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Mail\GeneralMail;
use App\Mail\UserWelcomeMail;
use App\Models\Estate;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletFundingTransactionLog;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
//use Flutterwave\Flutterwave;



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

            return $this->sendResponse($reference, "Payment Reference");
    }
    public function apiInitialize(Request $request)
    {
        $accounts =  json_encode([
            "id" => "RS_9E36EE8570C1E5BA42B118EB9CA44170"
        ], true);

//        return redirect()->to(url('/new'));

        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->estate_id = Auth::user()->estate_id;
        $transaction->description = "wallet Funding ".date("Y-m-d H:i:s");
        $transaction->amount = $request->amount;
        $transaction->gateway_commission = 0.00;
        $transaction->total_amount = $request->amount;
        $transaction->transaction_type = "credit";
        $transaction->transaction_status = "initiated";
        $transaction->transaction_reference = $reference;
        $transaction->date_initiated = date("Y-m-d H:i:s");
        $transaction->save();

        return $this->sendResponse($reference, "Payment Reference");


        // Enter the details of the payment
        $user = Auth::user();
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $request->amount,
            'email' => $user->email,
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('api.callback'),
            'customer' => [
                'email' => $user->email,
                "phone_number" => $user->phone,
                "name" => $user->surname." ".$user->othernames
            ],
            "subaccounts" => [
                $accounts
            ],

            "customizations" => [
                "title" => 'Movie Ticket',
                "description" => "20th October"
            ]
        ];

        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            dd($payment);
            // notify something went wrong
            return;
        }

        return $payment['data']['link'];
    }



    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback(Request $request)
    {
        $status = $request->status;
        $reference = $request->tx_ref;
        $transactionID = $request->transaction_id;
        $transaction = Transaction::where('transaction_reference', $reference)->first();
        if (!$transaction) return $this->sendError("Unknown Transaction.");

        $checkTransaction = WalletFundingTransactionLog::query()
            ->where('transaction_id', $transactionID)
            ->first();
        if ($checkTransaction) return $this->sendError("This transaction has been processed and has a status of {$checkTransaction->status}", 400);

        $response = $this->FlutterTransactionVerify($transactionID);

        WalletFundingTransactionLog::create([
            'transaction_id' => $transactionID,
            'transaction_reference' => $reference,
            'status' => $status,
            'response' => $response
        ]);

        if ($status ==  'successful') {

            $decoded_data = json_decode($response, true);

            $transaction->amount = $decoded_data['data']['amount_settled'];
            $transaction->gateway_commission = $decoded_data['data']['app_fee'];
            $transaction->total_amount = $decoded_data['data']['charged_amount'];
            $transaction->transaction_status = "successful";
            $message = "Wallet Successfully Funded.";
            $status = true;


            $wallet = $this->CreditWallet($decoded_data['data']['amount_settled']);
        }
        elseif ($status ==  'cancelled'){
            $transaction->transaction_status = "cancelled";
            $message = "User cancelled the transaction";
            $status = false;
        }
        else{
            $transaction->transaction_status = "failed";
            $message = "The transaction failed";
            $status = false;
        }
        $transaction->save();

        if ($status === false)
        {
            return $this->sendError($message);
        }
        $estate = Estate::query()
            ->find(Auth::user()->estate_id);
        $details = [
            "subject" => "Wallet Funding",
            "name" => Auth::user()->surname. " ".Auth::user()->othernames,
            "message" => "Your wallet has been funded with {$wallet->amount} <br> and your new wallet balance is {$wallet->current_balance}",
            "from" => $estate->mail_slug,
        ];

  /*      $email = new GeneralMail($details);
        Mail::to(Auth::user()->email)->queue($email);*/

        return $this->sendSuccess($message);
    }

    /**
     * @param $transactionID
     * @return bool|string
     */
    public function FlutterTransactionVerify($transactionID)
    {
        $secret_key = config('flutterwave.secretKey');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/" . $transactionID . "/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $secret_key
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * @param $amount_settled
     * @return Wallet
     */
    public function CreditWallet($amount_settled): Wallet
    {
        logger($amount_settled);
        $wallet = Wallet::query()->where('user_id', request()->user()->id)->first();
        logger($wallet);

        if ($wallet) {
            $walletPrev_balance = $wallet->current_balance;
        } else {
            $wallet = new Wallet();
            $walletPrev_balance = 0.00;
        }
        $wallet->user_id = Auth::id();
        $wallet->prev_balance = $walletPrev_balance;
        $wallet->amount = $amount_settled;
        $wallet->current_balance = $walletPrev_balance + $amount_settled;
        $wallet->transaction_type = 'credit';
        $wallet->save();
        $wallet->refresh();

        logger("refreshed wallet");
        logger(print_r($wallet, 1));

        WalletHistory::query()->create([
            'prev_balance' => $walletPrev_balance,
            'amount' => $amount_settled,
            'user_id' => Auth::id(),
            'current_balance' => $wallet->current_balance,
            'transaction_type' => 'credit',
            'description' => "Wallet Funding"
        ]);
        return $wallet;
    }


}
