<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVisitorPassAPIRequest;
use App\Http\Requests\API\UpdateVisitorPassAPIRequest;
use App\Http\Resources\VisitorPassResource;
use App\Mail\sendVisitorPassMail;
use App\Models\VisitorPass;
use App\Repositories\VisitorPassRepository;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Carbon\Carbon;
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

        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $visitorPasses = $this->visitorPassRepository->paginateViewBasedOnRole('20', ['*'], $search, $estate_id);


        return $this->sendResponse(VisitorPassResource::collection($visitorPasses)->response()->getData(true), 'Visitor Passes retrieved successfully');
    }

    /**
     * Display a listing of the visitor passes based on a particular user.
     * GET|HEAD /visitor_passes_per_user/{user_id}
     *
     * @param Request $request
     * @param user_id
     * @return Response
     */
    public function userIndex(Request $request, $user_id)
    {
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $invoices = $this->visitorPassRepository->paginateViewBasedOnUser('20', ['*'], $search, $estate_id, $user_id);

        return $this->sendResponse(VisitorPassResource::collection($invoices)->response()->getData(true), 'Invoices retrieved successfully');
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
        $code = mt_rand(100000, 999999);
        $generatedCode = str_shuffle($code);
        $date = date('Y-m-d H:i:s');
        $user = \request()->user();
        $request->merge(['generatedCode' => $generatedCode,'generatedDate' => $date, 'visitationDate' => $request->visitationDate]);
        $request->merge(['status' => "inactive", "user_id" => $user->id, 'estate_id' => $user->estate_id ?? 1]);
        $request->merge(['dateExpires' => Carbon::parse($request->visitationDate)->addHours($request->duration)]);

        $input = $request->all();

        $visitorPass = $this->visitorPassRepository->create($input);

        return $this->sendResponse(new VisitorPassResource( $visitorPass), 'Visitor Pass saved successfully');
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

        return $this->sendResponse($visitorPass->toArray(), 'Visitor Pass retrieved successfully');
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
        $active = $request->get('status');
        if ($invitation_code == null || $active == null) return $this->sendError("invalid URL");

        $today_date = date('Y-m-d');
//        return $today_date;
        $visitorPass = VisitorPass::query()
            ->where('generatedCode', $request->invitation_code)
//            ->where(\DB::raw('CAST(visitationDate as date)'), '>=', "2021-11-23")
            ->whereDate('visitationDate', date('Y-m-d'))
            ->first();
        if (!$visitorPass) return $this->sendError("Pass is either invalid or you're not scheduled for today.");

        if ($active == "active" && $visitorPass->status == "active") return $this->sendError("This Pass code is already in use.");
        $user = $visitorPass->user->surname." ".$visitorPass->user->surname;
        if ($active == "active"){
            $visitorPass->checked_in_time = date('Y-m-d h:i:s');
            $message = "Your guest {$visitorPass->guestname} has just been allowed into the estate at {$visitorPass->checked_in_time}";
        } else {
            $visitorPass->checked_out_time = date('Y-m-d h:i:s');
            $message = "Your guest {$visitorPass->guestname} has just been checkout of the estate at {$visitorPass->checked_out_time}";
        }
        $visitorPass->status = $active;
        $visitorPass->save();
        $visitor_pass = [
            "guestName" => $visitorPass->guestName,
            "gender" => $visitorPass->gender,
            "visitationDate" => date('Y-m-d', strtotime($visitorPass->visitationDate)),
            "dateExpires" => date('Y-m-d', strtotime($visitorPass->dateExpires)),
            "estate" => $visitorPass->estate->name,
            "user" => $visitorPass->user->surname,
        ];
        //TODO: Queued Mail to inform the user of the activity of the guest whether in or out
        $maildata = [
          $message => $message,
          $user => $user,
        ];
        $email = new sendVisitorPassMail($maildata);
        Mail::to($this->maildata['email'])->send($email);
        return $this->sendResponse($visitor_pass, "The pass code is valid");
    }
}
