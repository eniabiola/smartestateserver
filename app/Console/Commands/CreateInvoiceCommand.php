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
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        return Command::SUCCESS;
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
