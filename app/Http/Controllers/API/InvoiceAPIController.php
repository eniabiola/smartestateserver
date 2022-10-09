<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInvoiceAPIRequest;
use App\Http\Requests\API\UpdateInvoiceAPIRequest;
use App\Http\Resources\InvoiceResource;
use App\Mail\GeneralMail;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\InvoiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Response;

/**
 * Class InvoiceController
 * @package
 */

class InvoiceAPIController extends AppBaseController
{
    /** @var  InvoiceRepository */
    private $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepo)
    {
        $this->invoiceRepository = $invoiceRepo;
    }

    /**
     * Display a listing of the Invoice.
     * GET|HEAD /invoices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $invoices = $this->invoiceRepository->paginateViewBasedOnRole('20', ['*'], $search, $estate_id);

        return $this->sendResponse(InvoiceResource::collection($invoices)->response()->getData(true), 'Invoices retrieved successfully');
    }



    public function userOutstanding(Request $request)
    {
        $owing = Invoice::query()
            ->where('user_id', Auth::id())
            ->where('status', '=', "Not Paid")
            ->get();
        return $this->sendResponse($owing, "List of users outstandings");
    }

    public function allUsersOutstanding(Request $request)
    {

        $owing = Invoice::query()
            ->where('status', '=', "Not Paid")
            ->get();
        return $this->sendResponse($owing, "Outstanding of all users");
    }

    public function sumUserOutstanding(Request $request)
    {
        $amount = Invoice::query()
            ->where('status', '=', 'Not Paid')
            ->where('user_id', '=', Auth::id())
            ->sum('amount');
        return $this->sendResponse($amount, "Amount user is owing");
    }

    public function allSumUsersOutstanding()
    {

        $amount = Invoice::query()
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where('status', '=', 'Not Paid')
            ->groupBy('user_id')
            ->selectRaw('sum(amount) as amount, user_id, users.surname, users.othernames')
            ->get();

        return $this->sendResponse($amount, "Amount users are owing");
    }



    /**
     * Display a listing of the Invoice based on a particular user.
     * GET|HEAD /invoices_per_user/{user_id}
     *
     * @param Request $request
     * @param user_id
     * @return Response
     */
    public function userIndex(Request $request, $user_id)
    {
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $invoices = $this->invoiceRepository->paginateViewBasedOnUser('20', ['*'], $search, $estate_id, $user_id);

        return $this->sendResponse(InvoiceResource::collection($invoices)->response()->getData(true), 'Invoices retrieved successfully');
    }

    /**
     * Store a newly created Invoice in storage.
     * POST /invoices
     *
     * @param CreateInvoiceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateInvoiceAPIRequest $request)
    {
        $input = $request->all();

        $invoice = $this->invoiceRepository->create($input);

        return $this->sendResponse($invoice->toArray(), 'Invoice saved successfully');
    }

    /**
     * Display the specified Invoice.
     * GET|HEAD /invoices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (empty($invoice)) {
            return $this->sendError('Invoice not found');
        }

        return $this->sendResponse($invoice->toArray(), 'Invoice retrieved successfully');
    }

    /**
     * Update the specified Invoice in storage.
     * PUT/PATCH /invoices/{id}
     *
     * @param int $id
     * @param UpdateInvoiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInvoiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (empty($invoice)) {
            return $this->sendError('Invoice not found');
        }

        $invoice = $this->invoiceRepository->update($input, $id);

        return $this->sendResponse($invoice->toArray(), 'Invoice updated successfully');
    }

    /**
     * Remove the specified Invoice from storage.
     * DELETE /invoices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->find($id);

        if (empty($invoice)) {
            return $this->sendError('Invoice not found');
        }

        $invoice->delete();

        return $this->sendSuccess('Invoice deleted successfully');
    }


    /**
     * Update the specified Invoice in storage.
     * PUT/PATCH /invoices/{id}
     *
     * @param
     * @param Request $request
     *
     * @return Response
     */
    public function payInvoice(Request $request)
    {
//        return Auth::id();
        $this->validate($request, [
            'invoice_ids' => 'required|array|min:1',
            'invoice_ids.*' => 'required|integer|exists:invoices,id',
        ]);
        $input = $request->all();

        /** @var Invoice $invoice */
        $invoice = Invoice::query()
                    ->findMany($request->invoice_ids)
                    ->sum('amount');
        $wallet = Wallet::query()
                    ->where('user_id', Auth::id())
                    ->first();
        if ($invoice > $wallet->current_balance) return $this->sendError("You do not have sufficient money in your wallet, either fund or reduce number of invoices to pay", 400);

        $invoices = Invoice::query()
            ->findMany($request->invoice_ids);
//        return $invoices;
        try {
            $paid = 0;
            foreach ($invoices as $payable_invoice)
            {
                if ($payable_invoice->status == "Paid")
                {
                    continue;
                }
                DB::beginTransaction();
                $paid += $payable_invoice->amount;
                $payable_invoice->status = "Paid";
                $payable_invoice->save();

                $wallet =  Wallet::where('user_id', Auth::id())->first();
                $current_balance = $wallet->current_balance;
                $wallet->prev_balance = $current_balance;
                $wallet->amount = $payable_invoice->amount;
                $wallet->current_balance = $current_balance - $payable_invoice->amount;
                $wallet->transaction_type = "debit";
                $wallet->save();

                $transaction = new Transaction();
                $transaction->user_id = Auth::id();
                $transaction->estate_id = Auth::user()->estate_id;
                $transaction->description = $payable_invoice->description.date("Y-m-d");
                $transaction->amount = $payable_invoice->amount;
                $transaction->gateway_commission = 0;
                $transaction->total_amount = $payable_invoice->amount;
                $transaction->transaction_type = 'debit';
                $transaction->transaction_status = 'completed';
                $transaction->transaction_reference = $payable_invoice->invoiceNo;
                $transaction->date_initiated = date("Y-m-d H:i:s");
                $transaction->save();

                DB::commit();

            }

            $details = [
                "subject" => "Invoice Payment",
                "name" => Auth::user()->surname. " ".Auth::user()->othernames,
                "message" => "You have successfully paid your invoice(s) worth NGN{$paid} <br> and your new wallet balance is NGN{$wallet->current_balance}",
            ];

            $email = new GeneralMail($details);
            Mail::to(Auth::user()->email)->queue($email);
            return $this->sendSuccess("Invoice(s) successfully paid");
        } catch (\Exception $th)
        {
            return $this->sendError("Unable to pay invoice, contact administrator", 400);
        }
    }

}
