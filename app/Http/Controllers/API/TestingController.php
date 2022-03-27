<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Invoice;
use App\Models\User;
use App\Repositories\BillingRepository;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function billingJobTesting(BillingRepository $billingRepository)
    {

        $billings = $billingRepository->BillingJob();

        if ($billings == []) die;

        $users = User::query()
                ->whereHas('resident')
                ->get();

        $dailyBillings = $billingRepository->BillingJob()->where('bill_frequency', 'daily')->get();
        if (count($dailyBillings) > 0) $this->CreateInvoice($dailyBillings, $users);

        //if the freequency is monthly
        $monthlyBillings = $billingRepository->BillingJob()->where('bill_frequency', 'monthly')
            ->where('invoice_day', date('j'))->get();
        if (count($monthlyBillings) > 0)
        {
            $this->CreateInvoice($monthlyBillings, $users);
        }

        //if the frequency is yearly
        $yearlyBillings = $billingRepository->BillingJob()
                        ->where('bill_frequency', 'yearly')
                        ->where('invoice_day', date('j'))
                        ->where('invoice_month', date('n'))
                        ->get();
        if (count($yearlyBillings) > 0) $this->CreateInvoice($yearlyBillings, $users);

        \Log::info("The create invoice job ran at ".date('Y-m-d H:i:s'));
    }


    /**
     * @param $billings
     * @param $users
     * @return bool
     */
    protected function CreateInvoice($billings, $users): bool
    {
        foreach ($billings as $billing) {
            foreach ($users as $user) {
                $invoice = new Invoice();
                $invoice->billing_id = $billing->id;
                $invoice->user_id = $user->id;
                $invoice->estate_id = 1;
                $invoice->name = $billing->name;
                $invoice->description = $billing->description;
                $invoice->invoiceNo = "wewe";
                $invoice->amount = $billing->amount;
                $invoice->status = "Not Paid";
                $invoice->save();

            }
        }
        return true;
    }
}
