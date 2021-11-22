<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVisitorPassAPIRequest;
use App\Http\Requests\API\UpdateVisitorPassAPIRequest;
use App\Http\Resources\VisitorPassResource;
use App\Models\VisitorPass;
use App\Repositories\VisitorPassRepository;
use App\Services\UtilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

/**
 * Class VisitorPassController
 * @package
 */

class VisitorPassAPIController extends AppBaseController
{
    /** @var  VisitorPassRepository */
    private $visitorPassRepository;

    public function __construct(VisitorPassRepository $visitorPassRepo)
    {
        $this->visitorPassRepository = $visitorPassRepo;
    }

    /**
     * Display a listing of the VisitorPass.
     * GET|HEAD /visitorPasses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $visitorPasses = $this->visitorPassRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $visitorPasses = VisitorPass::query()
            ->where('estate_id', \request()->user()->estate_id)
            ->when(Auth::user()->hasRole('resident'), function($query){
                $query->where('user_id', Auth::user()->id);
            })
            ->get();

        return $this->sendResponse(VisitorPassResource::collection($visitorPasses), 'Visitor Passes retrieved successfully');
    }

    /**
     * Store a newly created VisitorPass in storage.
     * POST /visitorPasses
     *
     * @param CreateVisitorPassAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVisitorPassAPIRequest $request, UtilityService $utilityService)
    {
        $user = \request()->user();
        $request->merge(['generatedCode' => $utilityService->generateCode(6),'generatedDate' => date('Y-m-d H:i:s')]);
        $request->merge(['status' => "inactive", "user_id" => $user->id, 'estate_id' => $user->estate_id ?? 1]);
        $input = $request->all();

        $visitorPass = $this->visitorPassRepository->create($input);

        return $this->sendResponse( new VisitorPassResource($visitorPass), 'Visitor Pass saved successfully');
    }

    /**
     * Display the specified VisitorPass.
     * GET|HEAD /visitorPasses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VisitorPass $visitorPass */
        $visitorPass = $this->visitorPassRepository->find($id);

        if (empty($visitorPass)) {
            return $this->sendError('Visitor Pass not found');
        }

        return $this->sendResponse(new VisitorPassResource($visitorPass), 'Visitor Pass retrieved successfully');
    }

    /**
     * Update the specified VisitorPass in storage.
     * PUT/PATCH /visitorPasses/{id}
     *
     * @param int $id
     * @param UpdateVisitorPassAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVisitorPassAPIRequest $request)
    {
        $input = $request->all();

        /** @var VisitorPass $visitorPass */
        $visitorPass = $this->visitorPassRepository->find($id);

        if (empty($visitorPass)) {
            return $this->sendError('Visitor Pass not found');
        }

        $visitorPass = $this->visitorPassRepository->update($input, $id);

        return $this->sendResponse($visitorPass->toArray(), 'VisitorPass updated successfully');
    }

    /**
     * Remove the specified VisitorPass from storage.
     * DELETE /visitorPasses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VisitorPass $visitorPass */
        $visitorPass = $this->visitorPassRepository->find($id);

        if (empty($visitorPass)) {
            return $this->sendError('Visitor Pass not found');
        }

        $visitorPass->delete();

        return $this->sendSuccess('Visitor Pass deleted successfully');
    }

    public function passAuthentication(Request $request)
    {
        $invitation_code = $request->get('invitation_code');
        $status = $request->get('status');
        if ($invitation_code == null || $status == null){
            return $this->sendError("invalid URL");
        }

        $visitorPass = VisitorPass::query()
                                    ->where('generatedCode', $request->invitation_code)
//                                    ->where('dateExpires', '>=', date("Y-m-d"))
                                    ->first();
        if (!$visitorPass)
        {
            return $this->sendError("This Pass code is invalid");
        }
        if ($status == "active" && $visitorPass->status == "active") return $this->sendError("This Pass code is already in use.");

        if($status == "active")
        {
            $visitorPass->status = $status;
        } else {
            $visitorPass->status = "inactive";
        }

        $visitorPass->save();
        $visitor_pass = [
            "guestName" => $visitorPass->guestName,
            "gender" => $visitorPass->gender,
            "visitationDate" => date('Y-m-d', strtotime($visitorPass->visitationDate)),
            "dateExpires" => date('Y-m-d', strtotime($visitorPass->dateExpires)),
            "estate" => $visitorPass->estate->name,
            "user" => $visitorPass->user->surname,
        ];
        return $this->sendResponse($visitor_pass, "The pass code is valid");
    }
}
