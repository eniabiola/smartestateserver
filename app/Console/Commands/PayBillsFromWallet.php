<?php

namespace App\Console\Commands;

use App\Models\Billing;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayBillsFromWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay:bills';

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
        $invoices = Invoice::query()
                            ->where('status', '=', 'Not Paid')
                            ->get();
        foreach ($invoices as $invoice)
        {
            $user = User::find($invoice->user_id);
            $wallet  = Wallet::query()
                                     ->where('user_id', '=', $invoice->user_id)
                                     ->first();
            if (!$wallet) {  continue; }
            if ($wallet->current_balance  >= $invoice->amount)
            {
                $current_wallet_balance = $wallet->current_balance;
                $prev_balance = $wallet->prev_balance;
                $billing = Billing::find($invoice->billing_id);
                DB::beginTransaction();

                $invoice->status = "Paid";
                $invoice->save();
                $invoice->refresh();

                $wallet->prev_balance = $current_wallet_balance;
                $wallet->amount = $invoice->amount;
                $wallet->current_balance = $current_wallet_balance - $invoice->amount;
                $wallet->save();
                $wallet->refresh();

                WalletHistory::query()->create([
                    'prev_balance' => $prev_balance,
                    'amount' => $invoice->amount,
                    'user_id' => $invoice->user_id,
                    'current_balance' => $current_wallet_balance - $invoice->amount,
                    'transaction_type' => 'debit',
                    'description' => "Payment: ".$billing->name
                ]);


                DB::commit();
            }
        }



    }
}
