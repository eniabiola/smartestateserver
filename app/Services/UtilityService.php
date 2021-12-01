<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UtilityService {

    public function generateCode($length_of_string)
    {
        return substr(sha1(time()), 0, $length_of_string);
    }

    /**
     * @param $billings
     * @param $user
     * @return bool
     */
    public function CreateInvoice($billings, $user): bool
    {
        foreach ($billings as $billing) {
            $invoice = new Invoice;
            $invoice->billing_id = $billing->id;
            $invoice->user_id = $user->id;
            $invoice->estate_id = $user->estate_id;
            $invoice->name = $billing->name;
            $invoice->description = $billing->description;
            $invoice->invoiceNo = $this->generateCode(4);
            $invoice->amount = $billing->amount;
            $invoice->status = "Not Paid";
            $invoice->save();
        }
        return true;
    }

}
