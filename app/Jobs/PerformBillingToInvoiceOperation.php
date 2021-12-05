<?php

namespace App\Jobs;

use App\Mail\GeneralMail;
use App\Models\Billing;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

                $month   = \DateTime::createFromFormat('!n', $billing->due_month)->format('F');
                $day   = \DateTime::createFromFormat('!j', $billing->due_day)->format('S');
                $details = [
                    "subject" => "Invoice Payment",
                    "name" => $user->surname. " ".$user->othernames,
                    "message" => "This is to notify you that you have an invoice of {$billing->amount} for {$billing->description} to pay.
                    <br> This invoice is due {$day} {$month}",
                ];

                $email = new GeneralMail($details);
                Mail::to(Auth::user()->email)->queue($email);
            }
        }
        return true;
    }
}
