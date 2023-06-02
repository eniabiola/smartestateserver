<?php

namespace App\Console\Commands;

use App\Mail\GeneralMail;
use App\Models\Billing;
use App\Models\Estate;
use App\Models\Invoice;
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
        $users = User::query()
            ->whereHas("roles", function($q){
                $q->where("name", '=', 'resident');
            })
            ->get();

        $billings = Billing::query()
            ->where(function ($query){
                $query->where('bill_target', 'current')
                    ->orWhere('bill_target', 'both')
                    ->orWhere('bill_target', 'current_new');
            })
            ->where('status', '=', 'active')
            ->get();

        if (count($billings) == 0) { return; }

        foreach ($billings as $billing)
        {
            $day = date('j');
            $month = date('n');
            switch ($billing->bill_frequency) {
                case "daily":
                    $this->CreateInvoice($billing, $users);
                    logger("it ran daily invoice command.");
                break;
                case "monthly":
                    if ($day == $billing->invoice_day) $this->CreateInvoice($billing, $users);
                    logger("it ran monthly invoice command.");
                    break;
                case "yearly":
                    logger("it ran year invoice command.");
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
        if ($billing->bill_frequency == "daily")
        {
            $day   = date('d');
            $month   = date('m');
        } elseif ($billing->bill_frequency == "monthly"){

            $day   = date('d');
            $month   = \DateTime::createFromFormat('!j', $billing->invoice_day)->format('m');
        } else {
            $day   = \DateTime::createFromFormat('!n', $billing->invoice_month)->format('d');
            $month   = \DateTime::createFromFormat('!j', $billing->invoice_day)->format('m');
        }
            foreach ($users as $user) {
                if ($billing->estate_id != $user->estate_id) { continue; }
                Invoice::query()->firstOrCreate(
                    [
                        'user_id'       => $user->id,
                        'invoice_day'   => $day,
                        'invoice_month'   => $month,
                        'invoice_year'   => date('Y'),
                    ],[
                        'user_id'       => $user->id,
                        'invoice_day'   => $day,
                        'invoice_month'   => $month,
                        'invoice_year'   => date('Y'),
                        'billing_id' => $billing->id,
                        'user_id' => $user->id,
                        'estate_id' => $user->estate_id,
                        'name' => $billing->name,
                        'description' => $billing->description,
                        'invoiceNo' => uniqid("INV", true),
                        'amount' => $billing->amount,
                        'status' => "Not Paid",
                       ]
                );
                $estate = Estate::find($user->estate_id);
                $details = [
                    "subject" => "Invoice Payment",
                    "name" => $user->surname. " ".$user->othernames,
                    "from" => $estate->name,
                    "message" => "This is to notify you that you have an invoice of {$billing->amount} for {$billing->description} to pay.
                    <br>  Amount Due: {$billing->amount}",
                ];

                $email = new GeneralMail($details);
                Mail::to($user->email)->queue($email);
        }
        return true;
    }
}
