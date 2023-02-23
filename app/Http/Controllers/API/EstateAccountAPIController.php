<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\EstateAccount;
use App\Models\RandomInt;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\ApiCallTrait;
use phpDocumentor\Reflection\Types\Integer;
use App\Traits\FlutterPaymentTrait;

class EstateAccountAPIController extends AppBaseController
{
    use ResponseTrait, ApiCallTrait, FlutterPaymentTrait;

    //TODO for admin list all accounts and their accounts
    //TODO create new sub-accounts from flutter
    //TODO toggle sub-accounts status
    //TODO  delete sub-accounts

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $estate_id)
    {
        $estate = Estate::query()->find($estate_id);
        if (!$estate) {
            return $this->failedResponse("Estate not available");
        }
        $estate_account = EstateAccount::query()->where('estate_id', $estate_id)->first();
        if ($estate_account) {
            return $this->failedResponse("This estate has a profiled account already.");
        }


        $fields = [
            "account_bank" => $estate->bank->bank_code,
            "account_number" => $estate->accountNumber,
            "business_name" => $estate->accountName,
            "business_email" => $estate->email,
            "business_contact" => $estate->phone,
            "business_contact_mobile" => $estate->phone,
            "business_mobile" => $estate->phone,
            "country" => "NG"
        ];

        $profile_estate = $this->profileAccount($fields, $estate_id);
        if (!$profile_estate['status'])
        {
            return $this->failedResponse($profile_estate['message']);
        }
        return $this->successResponse($profile_estate['message'], 201, $profile_estate['data']);

        //Todo if it was a success enter it into the db table

        return $fields;
    }


    public function changeEstateAccount(Request $request)
    {
        /**
         * check if the estate exists
         * if it does
         * save the new data in the estate table
         * go to flutter wave to save the account, if successful delete the older account from flutterwave and db
         */
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateRandomNumbers()
    {
        $iterator = 10000;
        for ($i = 0; $i < $iterator; $i++)
        {
            $randomNR = $this->generateRandomInt();
            $random = new RandomInt();
            $random->number = $randomNR;
            $random->save();
        }
    }


    public function generateRandomInt(){
        do{
            $randomNR = mt_rand(100000000000000,999999999999999);
            $randomNR = 'g'.$randomNR;
            $exist = RandomInt::query()
                ->where('number', $randomNR)
                ->first();
        }while(!empty($exist));
        return $randomNR;
    }
}
