<?php

namespace App\Jobs;

use App\Models\Billing;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PerformBillingToInvoiceOperation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO: CHECK THE FREQUENCY, AND THE PERSONS IT SHOULD BE ADDRESSED TO, TO CREATE THE INVOICE USING THE METHOD
        /**
         * Get the billing with target as either current or both
         * What is the Frequency
         * Get the date, check if the date is today, then create the invoices
         */
        $billingsCount = Billing::query()->count();

        $billings = Billing::query()
                    ->where(function ($query){
                       $query->where('bill_target', 'current')
                            ->orWhere('bill_target', 'both');
                    })
                    ->get();
        if (count($billingsCount) == 0) die();
        $users = User::all();
        // if the frequency is daily
        return $this->CreateInvoice($billings, $users);

        //if the freequency is monthly

        //if the frequency is yearly


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
                $invoice = new Invoice;
                $invoice->billing_id = $billing->id;
                $invoice->user_id = $user->id;
                $invoice->estate_id = $user->estate_id;
                $invoice->name = $billing->name;
                $invoice->description = $billing->description;
                $invoice->invoiceNo = wewe;
                $invoice->amount = $billing->amount;
                $invoice->status = "Not Paid";
                $invoice->save();

            }
        }
        return true;
    }
}
