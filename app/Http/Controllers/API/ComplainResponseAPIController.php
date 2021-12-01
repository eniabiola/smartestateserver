<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateComplainResponseAPIRequest;
use App\Http\Requests\API\UpdateComplainResponseAPIRequest;
use App\Http\Resources\ComplainResponseResource;
use App\Models\Complain;
use App\Models\ComplainResponse;
use App\Repositories\ComplainResponseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class ComplainResponseController
 * @package
 */

class ComplainResponseAPIController extends AppBaseController
{
    /** @var  ComplainResponseRepository */
    private $complainResponseRepository;

    public function __construct(ComplainResponseRepository $complainResponseRepo)
    {
        $this->complainResponseRepository = $complainResponseRepo;
    }

    /**
     * Display a listing of the ComplainResponse.
     * GET|HEAD /complainResponses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $complainResponses = $this->complainResponseRepository->paginateViewBasedOnRole('20', ['*'], $search, $estate_id);

        return $this->sendResponse(ComplainResponseResource::collection($complainResponses)->response()->getData(true), 'Complain Responses retrieved successfully');
    }

    /**
     * Store a newly created ComplainResponse in storage.
     * POST /complainResponses
     *
     * @param CreateComplainResponseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateComplainResponseAPIRequest $request)
    {
        $complain = Complain::find($request->complain_id);
        $user_role =  request()->user()->roles[0]->name;
        if ($complain->user_id == Auth::id())
        {
            $isOwner = true;
        } else { $isOwner = false; }
        $request->merge(["isOwner" => $isOwner, "user_id" => Auth::id(), "estate_id" => request()->user()->estate_id,
                        "user_role" => $user_role]);
        $input = $request->all();

        $complainResponse = $this->complainResponseRepository->create($input);

        return $this->sendResponse(new ComplainResponseResource($complainResponse), 'Complain Response saved successfully');
    }

    /**
     * Display the specified ComplainResponse.
     * GET|HEAD /complainResponses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ComplainResponse $complainResponse */
        $complainResponse = $this->complainResponseRepository->find($id);

        if (empty($complainResponse)) {
            return $this->sendError('Complain Response not found');
        }

        return $this->sendResponse(new ComplainResponseResource($complainResponse), 'Complain Response retrieved successfully');
    }

    /**
     * Update the specified ComplainResponse in storage.
     * PUT/PATCH /complainResponses/{id}
     *
     * @param int $id
     * @param UpdateComplainResponseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComplainResponseAPIRequest $request)
    {
        $input = $request->all();

        /** @var ComplainResponse $complainResponse */
        $complainResponse = $this->complainResponseRepository->find($id);

        if (empty($complainResponse)) {
            return $this->sendError('Complain Response not found');
        }

        $complainResponse = $this->complainResponseRepository->update($input, $id);

        return $this->sendResponse(new ComplainResponseResource($complainResponse), 'ComplainResponse updated successfully');
    }

    /**
     * Remove the specified ComplainResponse from storage.
     * DELETE /complainResponses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ComplainResponse $complainResponse */
        $complainResponse = $this->complainResponseRepository->find($id);

        if (empty($complainResponse)) {
            return $this->sendError('Complain Response not found');
        }

        $complainResponse->delete();

        return $this->sendSuccess('Complain Response deleted successfully');
    }
}
