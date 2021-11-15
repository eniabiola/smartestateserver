<?php

namespace ;

use App\Http\Requests\API\CreateInvoiceAPIRequest;
use App\Http\Requests\API\UpdateInvoiceAPIRequest;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
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
        $invoices = $this->invoiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($invoices->toArray(), 'Invoices retrieved successfully');
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
}
