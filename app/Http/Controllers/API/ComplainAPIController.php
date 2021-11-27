<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateComplainAPIRequest;
use App\Http\Requests\API\UpdateComplainAPIRequest;
use App\Http\Resources\ComplainAPIResource;
use App\Models\Complain;
use App\Repositories\ComplainRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class ComplainController
 * @package
 */

class ComplainAPIController extends AppBaseController
{
    /** @var  ComplainRepository */
    private $complainRepository;

    public function __construct(ComplainRepository $complainRepo)
    {
        $this->complainRepository = $complainRepo;
    }

    /**
     * Display a listing of the Complain.
     * GET|HEAD /complains
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $complains = $this->complainRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ComplainAPIResource::collection($complains), 'Complains retrieved successfully');
    }

    /**
     * Store a newly created Complain in storage.
     * POST /complains
     *
     * @param CreateComplainAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateComplainAPIRequest $request)
    {
        $user = Auth::user();
        $ticket_id = Complain::query()->orderBy('created_at', 'DESC')->first() ?? 0;
        $ticket_id = "".str_pad($ticket_id+1, 5, '0', STR_PAD_LEFT);

        $request->merge(['user_id' => $user->id, 'estate_id' => $user->estate_id,
                         'ticket_no' => $ticket_id, 'status' => "active"]);
        $input = $request->all();

        $complain = $this->complainRepository->create($input);

        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain saved successfully');
    }

    /**
     * Display the specified Complain.
     * GET|HEAD /complains/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain retrieved successfully');
    }

    /**
     * Update the specified Complain in storage.
     * PUT/PATCH /complains/{id}
     *
     * @param int $id
     * @param UpdateComplainAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComplainAPIRequest $request)
    {
        $input = $request->all();

        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        $complain = $this->complainRepository->update($input, $id);

        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain updated successfully');
    }

    /**
     * Remove the specified Complain from storage.
     * DELETE /complains/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        $complain->delete();

        return $this->sendSuccess('Complain deleted successfully');
    }
}
