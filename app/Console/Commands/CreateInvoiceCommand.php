<?php

namespace App\Console\Commands;

use App\Mail\GeneralMail;
use App\Models\Billing;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateInvoiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Invoice as at when due';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //TODO: CHECK THE FREQUENCY, AND THE PERSONS IT SHOULD BE ADDRESSED TO, TO CREATE THE INVOICE USING THE METHOD
        /**
         * Get the billing with target as either current or both
         * What is the Frequency
         * Get the date, check if the date is today, then create the invoices
         */
        $users = User::all();

        $billingsCount = Billing::query()->count();
        if (count($billingsCount) == 0) die();

        $billings = Billing::query()
            ->where('bill_frequency', 'daily')
            ->where(function ($query){
                $query->where('bill_target', 'current')
                    ->orWhere('bill_target', 'both');
            })
            ->get();

        foreach ($billings as $billing)
        {
            $day = date('j');
            $month = date('n');
            switch ($billing->bill_frequency) {
                case "daily":
                    $this->CreateInvoice($billing, $users);
                break;
                case "monthly":
                    if ($day == $billing->invoice_day) $this->CreateInvoice($billing, $users);
                break;
                case "yearly":
                    if ($month == $billing->invoice_month && $day == $billing->invoice_day)
                    {
                        $this->CreateInvoice($billing, $users);
                    }
                break;
                default:
                    //nothing happens here;
            }

        }

        return Command::SUCCESS;
    }


    /**
     * @param $billings
     * @param $users
     * @return bool
     */
    protected function CreateInvoice($billing, $users): bool
    {
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

                $month   = \DateTime::createFromFormat('!n', $billing->invoice_month)->format('F');
                $day   = \DateTime::createFromFormat('!j', $billing->invoice_day)->format('S');
                $details = [
                    "subject" => "Invoice Payment",
                    "name" => $user->surname. " ".$user->othernames,
                    "message" => "This is to notify you that you have an invoice of {$billing->amount} for {$billing->description} to pay.
                    <br>  Amount Due: {$billing->amount}",
                ];

                $email = new GeneralMail($details);
                Mail::to(Auth::user()->email)->queue($email);
        }
        return true;
    }
}
