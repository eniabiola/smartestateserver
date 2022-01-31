<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVisitorPassAPIRequest;
use App\Http\Requests\API\UpdateVisitorPassAPIRequest;
use App\Http\Resources\VisitorPassResource;
use App\Mail\GeneralMail;
use App\Mail\sendVisitorPassMail;
use App\Models\Estate;
use App\Models\User;
use App\Models\VisitorGroup;
use App\Models\VisitorPass;
use App\Models\VisitorPassGroup;
use App\Repositories\VisitorPassRepository;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Mail;
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
        $visitor_passes = $this->visitorPassRepository->paginateViewBasedOnUser('20', ['*'], $search, $estate_id, $user_id);

        return $this->sendResponse(VisitorPassResource::collection($visitor_passes)->response()->getData(true), 'Invoices retrieved successfully');
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

        $estate = Estate::find($user->estate_id);
        $input = $request->all();
        $message = 'Visitor Pass saved successfully';

        $visitorPass = $this->visitorPassRepository->create($input);
        if ($request->pass_type == "group"){
            $visitorGroup = new VisitorPassGroup();
            $visitorGroup->visitor_pass_id = $visitorPass->id;
            $visitorGroup->event = $request->event;
            $visitorGroup->expected_number_of_guests = $request->expected_number_of_guests;
            $visitorGroup->save();
            $message = "Your group pass request has been submitted to the Estate Administrator for Approval";

            $details = [
                "subject" => "New Group Pass Created",
                "name" => "Estate Administrator",
                "message" => "A new group pass has been created by {$user->surname} {$user->othernames}. This requires your authorization.",
                "email" => $estate->email
            ];
            $email = new GeneralMail($details);
            Mail::to($details['email'])->queue($email);
        }
        return $this->sendResponse(new VisitorPassResource($visitorPass), $message);
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
        /** @var VisitorPass $visitorPass */
        $visitorPass = $this->visitorPassRepository->find($id);

        if (empty($visitorPass)) {
            return $this->sendError('Visitor Pass not found');
        }

        if ($request->pass_type == "group"){

            $visitorPassGroup = VisitorPassGroup::query()->where('visitor_pass_id', $id)->first();
            if ($visitorPassGroup){

            } else{
                $visitorGroup = new VisitorPassGroup();
            }
            VisitorPassGroup::query()->updateOrCreate(
                ['visitor_pass_id', $id],
                []);
            $visitorGroup->visitor_pass_id = $visitorPass->id;
            $visitorGroup->event = $request->event;
            $visitorGroup->expected_number_of_guests = $request->expected_number_of_guests;
            $visitorGroup->save();
        }

        $old_expected_number_guest = $visitorPass->expected_number_guests;
        $in_already = $visitorPass->expected_number_guests - $visitorPass->remaining_number_guests;
        $request->merge(['remaining_number_guests' => $request->expected_number_guests - $in_already]);
        $input = $request->all();
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

        $visitorPass = VisitorPass::query()
            ->where('generatedCode', $request->invitation_code)
            ->first();

        if (!$visitorPass) return $this->sendError("Pass is invalid.");
        if ($visitorPass->pass_type == "group") {
            $visitorPassGroup = VisitorPassGroup::query()->where('visitor_pass_id', $visitorPass->id)->first();
            if ($visitorPassGroup->isApproved != true && $active != "close") return $this->sendError("This group Pass has not been approved");
        }

        switch ($active)
        {
            case "active":
                if ($visitorPass->status == "closed" && $visitorPass->pass_type == "individual") return $this->sendError("This pass code is used.");
                $message = "Your guest ". $visitorPass->guestname ." has arrived.";
                if ($visitorPass->status == "active" && $visitorPass->pass_type == "individual") return $this->sendError("This Pass code is already in use.");

                if (strtotime(date("Y-m-d", strtotime($visitorPass->visitationDate))) != strtotime(date("Y-m-d"))) return $this->sendError("This Pass code is not scheduled for today.");
                if ($visitorPass->pass_type == "group")
                {
                    if ($visitorPassGroup->expected_number_of_guests == $visitorPassGroup->number_of_guests_in)
                        return $this->sendError("This group pass has reached its limit");
                    $visitorPassGroup->number_of_guests_in  += 1;
                    $visitorPassGroup->save();
                    $message = "Your guest has arrived";
                }
                if ($visitorPass->pass_type == "individual" && $visitorPass->status == "active")
                    return $this->sendError("The visitor pass is already in use");
                $visitorPass->checked_in_time = date('Y-m-d h:i:s');
                break;
            case "cancelled":
                if ($visitorPass->status != "inactive")
                    return $this->sendError("You cannot cancel a pass in use or used..");
                break;
            case "closed":
                if ($visitorPass->status == "closed" && $visitorPass->pass_type == "individual") return $this->sendError("This pass code is used.");
                $message = "Your guest ". $visitorPass->guestname ." has departed";
/*                if ($visitorPass->status != "active")
                    return $this->sendError("This pass has not been used.");*/
                if ($visitorPass->pass_type == "group")
                {
                    if ($visitorPassGroup->expected_number_of_guests == $visitorPassGroup->number_of_guests_out)
                        return $this->sendError("All guests who entered with this pass code are out", 400);
                    $visitorPassGroup->number_of_guests_out  += 1;
                    $visitorPassGroup->save();

                    if ($visitorPassGroup->expected_number_of_guests != $visitorPassGroup->number_of_guests_out)
                        $active = "active";
                }
                $visitorPass->checked_out_time = date('Y-m-d h:i:s');
                $message = "Your guest has departed.";
                break;
            default:
                return $this->sendError("Not Valid");
                break;
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
            "status" => $visitorPass->status,
        ];

        if (($active == "active" || $active == "inactive") && $visitorPass->pass_type == "individual")
        {

            $user = $visitorPass->user->surname." ".$visitorPass->user->surname;
            $maildata = [
                "message" => $message,
                "user" => $user,
            ];
            $email = new sendVisitorPassMail($maildata);
            Mail::to($visitorPass->user->email)->send($email);
        }
        return $this->sendResponse($visitor_pass, "The pass code is valid");
    }

    public function activateDeactivatePass($id, Request $request)
    {
        $request->validate([
            'authorization' => 'required|string|in:approved,rejected',
            'authorization_comment'      =>  'nullable|required_if:authorization,==,rejected|string|max:200'
        ]);
        $visitorPass = VisitorPass::query()->find($id);
        if (!$visitorPass) { return $this->sendError("VisitorPass does not exist."); }
        if ($visitorPass->pass_type != "group") { return $this->sendError("VisitorPass does not need authorization."); }
//        if (!$visitorPass) { return $this->sendError("VisitorPass does not exist."); }
        $visitorPass->status = $request->authorization;
        $visitorPass->authorization_comment = $request->authorization_comment;
        $visitorPass->save();

        $visitorPassGroup = VisitorPassGroup::query()->where('visitor_pass_id', $id)->first();
        $visitorPassGroup->isApproved = true;
        $visitorPassGroup->save();

        $user = User::query()->find($visitorPass->user_id);
        $details = [
            "subject" => "Group Pass Status",
            "name" => $user->surname. " ".$user->othernames,
            "message" => "Your pass has been {$request->authorization}. {$request->authorization_comment}.",
            "email" => $user->email
        ];
        $email = new GeneralMail($details);
        Mail::to($details['email'])->queue($email);

        return $this->sendResponse($visitorPass, "Pass successfully {$request->authorization}");

    }
}
