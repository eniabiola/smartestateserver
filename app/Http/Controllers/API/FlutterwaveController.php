<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Transaction;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        $transaction = Transaction::where('transaction_reference', $reference)->first();
        if (!$transaction) return $this->sendError("Unknown Transaction.");
        //if payment is successful
        if ($status ==  'successful') {
            $transactionID = $request->transaction_id;
//            $data = Flutterwave::verifyTransaction($transactionID);
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
            $decoded_data = json_decode($response, true);

            $transaction->transaction_status = "successful";
            $message = "Wallet Successfully Funded.";
            $status = false;
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

        $walletHistory = new WalletHistory();

        $walletHistory->save();
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }


}
