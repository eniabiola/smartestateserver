<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBillingAPIRequest;
use App\Http\Requests\API\UpdateBillingAPIRequest;
use App\Http\Resources\BillingResource;
use App\Models\Billing;
use App\Models\Invoice;
use App\Repositories\BillingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class BillingController
 * @package
 */

class BillingAPIController extends AppBaseController
{
    /** @var  BillingRepository */
    private $billingRepository;

    public function __construct(BillingRepository $billingRepo)
    {
        $this->billingRepository = $billingRepo;
    }

    /**
     * Display a listing of the Billing.
     * GET|HEAD /billings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $billings = $this->billingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(BillingResource::collection($billings), 'Billings retrieved successfully');
    }

    public function paginatedIndex(Request $request)
    {
        $status = $request->get('status') ?? null;
        $billings = Billing::query()
            ->when(!is_null($status) && $status != "null", function ($q) use ($status){
                    $q->where('status', '=', strtolower($status));
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return $this->sendResponse(BillingResource::collection($billings)->response()->getData(true), 'Billings retrieved successfully');
    }

    /**
     * Store a newly created Billing in storage.
     * POST /billings
     *
     * @param CreateBillingAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBillingAPIRequest $request)
    {
        $user = \request()->user();

        $request->merge(['created_by' => $user->id, 'estate_id' => $user->estate_id,
            'invoice_day' => !empty($request->invoice_day) ? intval($request->invoice_day) : null,
            'invoice_month' => !empty($request->invoice_month) ? intval($request->invoice_month) : null,
            ]);

        $input = $request->all();

        $billing = $this->billingRepository->create($input);

        return $this->sendResponse($billing->toArray(), 'Billing saved successfully');
    }

    /**
     * Display the specified Billing.
     * GET|HEAD /billings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Billing $billing */
        $billing = $this->billingRepository->find($id);

        if (empty($billing)) {
            return $this->sendError('Billing not found');
        }

        return $this->sendResponse($billing->toArray(), 'Billing retrieved successfully');
    }

    /**
     * Update the specified Billing in storage.
     * PUT/PATCH /billings/{id}
     *
     * @param int $id
     * @param UpdateBillingAPIRequest $request
     *
     * @return Response
     */
    public function update(int $id, UpdateBillingAPIRequest $request)
    {
        $input = $request->all();

        /** @var Billing $billing */
        $billing = $this->billingRepository->find($id);

        if (empty($billing)) {
            return $this->sendError('Billing not found');
        }

        $billing = $this->billingRepository->update($input, $id);

        return $this->sendResponse($billing->toArray(), 'Billing updated successfully');
    }

    /**
     * Remove the specified Billing from storage.
     * DELETE /billings/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Billing $billing */
        $billing = $this->billingRepository->find($id);

        if (empty($billing)) {
            return $this->sendError('Billing not found');
        }
        try {
            $billing->delete();
        } catch (\Throwable $th)
        {
            logger("Billing error occurring on ".date("Y-m-d h:i:s"));
            report($th);
            return $this->sendError("Unable to delete billing item");
        }

        return $this->sendSuccess('Billing deleted successfully');
    }

    public function toggleStatus($billing_id)
    {
        $billing = Billing::find($billing_id);
        if (!$billing) { return $this->sendError("No such billing found"); }
        if ($billing->status  == "active")
        {
            $billing->status = "inactive";
            $message = "Billing is now inactive";
        } else {
            $billing->status = "active";
            $message = "Billing is now active";
        }
        $billing->save();
        return $this->sendSuccess($message);
    }
}
