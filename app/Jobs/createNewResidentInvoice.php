<?php

namespace App\Jobs;

use App\Models\Billing;
use App\Services\UtilityService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class createNewResidentInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UtilityService $utilityService)
    {
        $billings = Billing::query()
            ->where('bill_target', 'new')
            ->get();
        $utilityService->CreateInvoice($billings, $this->user);
        //TODO Send mail that they have invoice to pay
    }
}
