<?php

namespace App\Http\Controllers\API;

use App\Events\PrivatePushEvents;
use App\Http\Requests\API\CreateVisitorPassAPIRequest;
use App\Http\Requests\API\UpdateVisitorPassAPIRequest;
use App\Http\Resources\VisitorPassResource;
use App\Mail\GeneralMail;
use App\Mail\sendVisitorPassMail;
use App\Models\Estate;
use App\Models\Setting;
use App\Models\User;
use App\Models\VisitorGroup;
use App\Models\VisitorPass;
use App\Models\VisitorPassGroup;
use App\Notifications\adminAuthorizeGroupCode;
use App\Notifications\residentGenerateGroupCode;
use App\Notifications\residentVisitorPassStatus;
use App\Repositories\VisitorPassRepository;
use App\Services\DatatableService;
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

    public function indexDataTable(Request $request, DatatableService $datatableService)
    {
        $role_id = auth()->user()->roles[0]->id;
        $date_from = $request->query('date_from') != "null" && $request->query('date_from') != "" ? $request->query('date_from') : null;
        $date_to = $request->query('date_to') != "null" && $request->query('date_to') != "" ? $request->query('date_to') : null;
        $guest_name = $request->query('guest_name') != "null" && $request->query('guest_name') != "" ? $request->query('guest_name') : null;
        $generated_code = $request->query('pass_code') != "null" && $request->query('pass_code') != "" ? $request->query('pass_code') : null;
        $status = $request->query('status') != "null" && $request->query('status') != "" ? $request->query('status') : null;

        $search = [];
        $processedRequest = $datatableService->processRequest($request);
        $search_request = $processedRequest['search'];

        $search = $this->visitorPassRepository->getDataTableSearchParams($processedRequest, $search_request);

        $builder = $this->visitorPassRepository->builderBasedOnRole('visitor_passes.estate_id', $request->get('estate_id'))
            ->join('users', 'users.id', 'visitor_passes.user_id')
            ->join('estates', 'estates.id', 'visitor_passes.estate_id')
            ->select('visitor_passes.*',
                'estates.name AS estates__dot__name',
                'users.surname AS users__dot__surname',
                'users.othernames AS users__dot__othernames',
                'users.phone AS users__dot__phone',
                'users.email AS users__dot__email',)
            ->when($search_request != null, function ($query) use($search_request, $search){
                $query->where(function($query) use($search_request, $search){
                    foreach($search as $key => $value) {
                        if (in_array($key, $this->visitorPassRepository->getFieldsSearchable())) {
                            $query->orWhere($key, 'LIKE', '%'.$value.'%');
                        }
                    }
                });
            })
            ->when(!is_null($date_from) && !is_null($date_to), function ($query) use($date_from, $date_to){
                $from = Carbon::parse($date_from)->startOfDay()->format("Y-m-d H:i:s");
                $to = Carbon::parse($date_to)->endOfDay()->format("Y-m-d H:i:s");
                $query->whereBetween("visitor_passes.created_at", [$from, $to]);
            })
            ->when(!is_null($status), function ($query) use($status){
                $query->where("visitor_passes.status", $status);
            })
            ->when(!is_null($guest_name), function ($query) use($guest_name){
                $query->where("visitor_passes.guestName", $guest_name);
            })
            ->when(!is_null($generated_code), function ($query) use($generated_code){
                $query->where("visitor_passes.generatedCode", $generated_code);
            });

        $columns = $this->visitorPassRepository->getTableColumns();
        array_push($columns, "users.surname", "users.othernames", "users.phone", "users.email");

        return $datatableService->dataTable2($request, $builder, [
            '*',
            'name' => function (VisitorPass $visitorPass) {
                return $visitorPass->users__dot__surname ." ".$visitorPass->users__dot__othernames;
            },
            'status' => function (VisitorPass $visitorPass) {
                if($visitorPass->status == null || $visitorPass->status == strtolower("inactive")) return "<span class='badge badge-pill badge-info'>Open</span> ";
                if($visitorPass->status == strtolower("active")) return "<span class='badge badge-pill badge-success'>Checked In</span>";
                if($visitorPass->status == strtolower("approved")) return "<span class='badge badge-pill badge-success'>Approved</span>";
                if($visitorPass->status == strtolower("close") || $visitorPass->status == "closed") return "<span class='badge badge-pill badge-dark'>Checkedout Out</span>";
                if($visitorPass->status == strtolower("rejected")) return "<span class='badge badge-pill badge-danger'>Rejected</span>";
                if($visitorPass->status == strtolower("expired")) return "<span class='badge badge-pill badge-danger'>Expired</span>";
            },
            'action' => function (VisitorPass $visitorPass) use($role_id) {
                $button = null;
                if ($visitorPass->status == "open" && $role_id == 4)
                {
                    $button = "<button class='dropdown-item' id='checkout__$visitorPass->id' type='button'> Check out</button>
                    <button class='dropdown-item' id='checkin__$visitorPass->id' type='button'> Check in</button>";
                }
                return "
                <div class='datatable-actions'>
                    <div class='text-center'>
                        <div class='dropdown'>
                            <button  class='btn btn-primary dropdown-toggle button' type='button' id='dropdownMenuButton'
                            data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                Actions
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <button class='edit-card dropdown-item'id='viewpass__".$visitorPass->id."' type='button'>
                                    View pass
                                </button>
                                $button
                                <button class='dropdown-item'  id='shareviamessage__$visitorPass->id' type='button'>
                                    Share via message
                                </button>
                                <button class='dropdown-item'  id='shareviawhatsapp__$visitorPass->id' type='button'>
                                    Share via whatsapp
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
        ], $columns);
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
        $visitor_pass_count = VisitorPass::query()
            ->where('user_id', Auth::user()->id)
            ->whereDate('created_at', Carbon::today())
            ->count();


        if (!\request()->user()->hasRole('administrator')){

            $settings = Setting::query()
                ->where('name', 'pass_count')
                ->where('estate_id', Auth::user()->estate_id)
                ->first();
            if ($settings)
            {
                // \Log::info($visitor_pass_count." ! ".intval($settings->val));
                if ($visitor_pass_count >= intval($settings->val))
                {
                    return $this->sendError("You have reached your daily visitor pass quota limit");
                }
                $pass_remaining = intval($settings->val) - intval($visitor_pass_count);
            }
        } else {
            $pass_remaining = "unlimited";
        }


        $generatedCode = $this->generateUniqueCode();
//        $generatedCode = str_shuffle($code);
        $date = date('Y-m-d H:i:s');
        $user = \request()->user();
        $request->merge(['generatedCode' => $generatedCode,'generatedDate' => $date, 'visitationDate' => $request->visitationDate]);
        $request->merge(['status' => "inactive", "user_id" => $user->id, 'estate_id' => $user->estate_id ?? 1]);
        $request->merge(['dateExpires' => Carbon::parse($request->visitationDate)->addHours($request->duration)]);

        $estate = Estate::find($user->estate_id);
        $input = $request->all();
        $message = 'Visitor Pass saved successfully and you have '. $pass_remaining .' visitor pass left for today';

        $visitorPass = $this->visitorPassRepository->create($input);
        if ($request->pass_type == "group"){
            $visitorGroup = new VisitorPassGroup();
            $visitorGroup->visitor_pass_id = $visitorPass->id;
            $visitorGroup->event = $request->event;
            $visitorGroup->expected_number_of_guests = $request->expected_number_of_guests;
            $visitorGroup->save();
            $message = "Your group pass request has been submitted to the Estate Administrator for Approval";

            $admins = User::query()
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->where('model_has_roles.role_id', '=', 2) //assumes that admin id = 2
                ->where('users.estate_id', '=', $estate->id)
                ->get();
            foreach ($admins as $admin)
            {
                $admin->notify(new residentGenerateGroupCode($user));
            }
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
        date_default_timezone_set('Africa/Lagos');

        $array = [
            "url" => \request()->fullUrl(),
            "ip" => \request()->ip(),
            "sent_requests" => $request->all()
        ];
        file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication request: @ ' .date("Y-m-d H:i:s") .' '. print_r($array, true) . "\n\n", FILE_APPEND);
        $invitation_code = $request->get('invitation_code');
        $active = $request->get('status');
        if ($invitation_code == null || $active == null) {
            file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication response: @ ' .date("Y-m-d H:i:s") .' '. print_r("invalid URL", true) . "\n\n", FILE_APPEND);
            return $this->sendError("invalid URL");
        }

        $visitorPass = VisitorPass::query()
            ->where('generatedCode', $request->invitation_code)
            ->first();

        if (!$visitorPass) {
            file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication response: @ ' .date("Y-m-d H:i:s") .' '. print_r("Pass is invalid.", true) . "\n\n", FILE_APPEND);
            return $this->sendError("Pass is invalid.");
        }
        if ($visitorPass->pass_type == "group") {
            $visitorPassGroup = VisitorPassGroup::query()->where('visitor_pass_id', $visitorPass->id)->first();
            if ($visitorPassGroup->isApproved != true && $active != "close") {
                file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication response: @ ' .date("Y-m-d H:i:s") .' '. print_r("This group Pass has not been approved", true) . "\n\n", FILE_APPEND);
                return $this->sendError("This group Pass has not been approved");
            }
        }
        $now = Carbon::now()->timezone('Africa/Lagos')->format("Y-m-d H:i:s");
        $entry_date = $visitorPass->visitationDate;
        $entry_date_formatted =  Carbon::parse($entry_date)->format("Y-m-d H:i:s");
        $exit_date = Carbon::parse($entry_date)->addHour($visitorPass->duration)->format("Y-m-d H:i:s");

        switch ($active)
        {
            case "active":

                if ($visitorPass->status == "closed" && $visitorPass->pass_type == "individual") {
                    file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication response: @ ' .date("Y-m-d H:i:s") .' '. print_r("This group Pass has not been approved", true) . "\n\n", FILE_APPEND);
                    return $this->sendError("This pass code is used.");
                }

                $message = "Your guest ". $visitorPass->guestname ." has arrived.";
                if ($visitorPass->status == "active" && $visitorPass->pass_type == "individual") {
                    file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication response: @ ' .date("Y-m-d H:i:s") .' '. print_r("This Pass code is already in use.", true) . "\n\n", FILE_APPEND);
                    return $this->sendError("This Pass code is already in use.");
                }

                if (($now >= $entry_date_formatted) && ($exit_date <= $now) == true) {
                    file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication response: @ ' .date("Y-m-d H:i:s") .' '. print_r("This Pass code is not scheduled for today.", true) . "\n\n", FILE_APPEND);
                    return $this->sendError("This Pass code is not scheduled for today.");
                }
                if ($visitorPass->pass_type == "group")
                {
                    if ($visitorPassGroup->expected_number_of_guests == $visitorPassGroup->number_of_guests_in)
                    {
                        file_put_contents('pass_authentication' . date('Y-m-d') . '.txt', 'Pass Authentication response: @ ' . date("Y-m-d H:i:s") . ' ' . print_r("This group pass has reached its limit", true) . "\n\n", FILE_APPEND);
                        return $this->sendError("This group pass has reached its limit");
                    }
                    $visitorPassGroup->number_of_guests_in  += 1;
                    $visitorPassGroup->save();
                    $message = "Your guest has arrived";
                }
                if ($visitorPass->pass_type == "individual" && $visitorPass->status == "active") {
                    file_put_contents('pass_authentication' . date('Y-m-d') . '.txt', 'Pass Authentication response: @ ' . date("Y-m-d H:i:s") . ' ' . print_r("The visitor pass is already in use", true) . "\n\n", FILE_APPEND);
                    return $this->sendError("The visitor pass is already in use");
                }
                $visitorPass->checked_in_time = date('Y-m-d H:i:s');
                break;
            case "cancelled":
                if ($visitorPass->status != "inactive") {
                    file_put_contents('pass_authentication' . date('Y-m-d') . '.txt', 'Pass Authentication response: @ ' . date("Y-m-d H:i:s") . ' ' . print_r("You cannot cancel a pass in use or used.", true) . "\n\n", FILE_APPEND);
                    return $this->sendError("You cannot cancel a pass in use or used.");
                }
                break;
            case "closed":
                if (($now >= $entry_date_formatted) && ($exit_date <= $now) == true) {
                    file_put_contents('pass_authentication'.date('Y-m-d').'.txt', 'Pass Authentication response: @ ' .date("Y-m-d H:i:s") .' '. print_r("This Pass code is not scheduled for today.", true) . "\n\n", FILE_APPEND);
                    return $this->sendError("This Pass code is not scheduled for today.");
                }
                if ($now > $exit_date) { return $this->sendError("The pass has expired, you overstayed."); }
                if ($visitorPass->status == "closed" && $visitorPass->pass_type == "individual") return $this->sendError("This pass code is used.");
                $message = "Your guest ". $visitorPass->guestname ." has departed";
                if ($visitorPass->pass_type == "group")
                {
                    if ($visitorPassGroup->expected_number_of_guests == $visitorPassGroup->number_of_guests_out) {
                        file_put_contents('pass_authentication' . date('Y-m-d') . '.txt', 'Pass Authentication response: @ ' . date("Y-m-d H:i:s") . ' ' . print_r("All guests who entered with this pass code are out", true) . "\n\n", FILE_APPEND);
                        return $this->sendError("All guests who entered with this pass code are out", 400);
                    }
                    $visitorPassGroup->number_of_guests_out  += 1;
                    $visitorPassGroup->save();

                    if ($visitorPassGroup->expected_number_of_guests != $visitorPassGroup->number_of_guests_out)
                        $active = "active";
                }
                $visitorPass->checked_out_time = date('Y-m-d H:i:s');
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
            $status = $active == "active" ? "checked-in" : "checked-out";
            $message = "Guest Alert: Your Guest ".$visitorPass->guestName ." has been ".$status;
            $user = User::find($visitorPass->user_id);
//            event( new PrivatePushEvents($user, $message) );
            $user->notify(new residentVisitorPassStatus($message));
        }

        return $this->sendResponse($visitor_pass, "The pass code is valid");
    }

    public function activateDeactivatePass($id, Request $request)
    {
        $user = \request()->user();
        $estate = Estate::find($user->estate_id);
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
        $user->notify(new adminAuthorizeGroupCode($request->authorization, $visitorPass->generatedCode));
        return $this->sendResponse($visitorPass, "Pass successfully {$request->authorization}");

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (VisitorPass::where("generatedCode", "=", $code)->first());

        return $code;
    }

    //deleted repeated code rows
    public function deleteRepeatedFunctions()
    {
        $visitorPasses = VisitorPass::all();
        $visitorPassesUnique = $visitorPasses->unique('id');
        $visitorPassesDupes = $visitorPasses->diff($visitorPassesUnique);

        dd($visitorPasses, $visitorPassesUnique, $visitorPassesDupes);
    }

}
