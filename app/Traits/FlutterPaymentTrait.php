<?php


namespace App\Traits;


use App\Models\EstateAccount;
use App\Traits\ApiCallTrait;

trait FlutterPaymentTrait
{
    use ApiCallTrait;

    public function profileAccount(array $estate_details, int $estate_id)
    {
        $secret_key = config('flutterwave.secretKey');

        $headers = ["Authorization:" => "Bearer " . $secret_key];
        $url = "https://api.flutterwave.com/v3/subaccounts";
        $result = $this->curlPost1($url, $estate_details);
        if ($result['status'] == "error")
        {
            \Log::info($result['message']);
            return [
                "data"  => [],
                "status" => false,
                "message" => "Unable to profile merchant account, please contact the administrator"
            ];
        }
        if ($result['status'] == "success"){
            $estate_account = EstateAccount::query()->updateOrCreate(
                [
                    "estate_id"         => $estate_id,
                ],
                [
                    "bank_code"         => $result['data']['account_bank'],
                    "account_number"    => $result['data']['account_number'],
                    "account_name"      => $result['data']['full_name'],
                    "split_type"        => $result['data']['split_type'],
                    "split_value"       => $result['data']['split_value'],
                    "subaccount_id"     => $result['data']['subaccount_id']
                ]
            );
            return [
                "data" => $estate_account,
                "status" => true,
                "message" => "Account has been successfully profiled."
            ];
        }

    }
}
