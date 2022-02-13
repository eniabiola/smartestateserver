<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateComplainAPIRequest;
use App\Http\Requests\API\UpdateComplainAPIRequest;
use App\Http\Resources\ComplainAPIResource;
use App\Http\Resources\ComplainCollection;
use App\Http\Resources\ComplainNotification;
use App\Mail\GeneralMail;
use App\Models\Complain;
use App\Models\ComplainCategory;
use App\Models\Estate;
use App\Models\Setting;
use App\Repositories\ComplainRepository;
use App\Services\DatatableService;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $complains = $this->complainRepository->paginateViewBasedOnRole('20', ['*'], $search, $estate_id);

        return $this->sendResponse(ComplainAPIResource::collection($complains)->response()->getData(true), 'Complains retrieved successfully');
    }

    public function indexDataTable(Request $request, DatatableService $datatableService)
    {
        $date_from = $request->query('date_from') != "null" && $request->query('date_from') != "" ? $request->query('date_from') : null;
        $date_to = $request->query('date_to') != "null" && $request->query('date_to') != "" ? $request->query('date_to') : null;
        $category = $request->query('category') != "null" && $request->query('category') != "" ? $request->query('category') : null;
        $priority = $request->query('priority') != "null" && $request->query('priority') != "" ? $request->query('priority') : null;
        $status = $request->query('status') != "null" && $request->query('status') != "" ? $request->query('status') : null;
        $search = [];

//        return $priority;
        $processedRequest = $datatableService->processRequest($request);
        $search_request = $processedRequest['search'];

        $search = $this->complainRepository->getDataTableSearchParams($processedRequest, $search_request);

        $builder = $this->complainRepository->builderBasedOnRole('complains.estate_id', $request->get('estate_id'))
            ->join('users', 'users.id', 'complains.user_id')
            ->leftJoin('estates', 'estates.id', 'complains.estate_id')
            ->select('complains.*',
                'estates.name AS estates__dot__name',
            )
            ->when($search_request != null, function ($query) use($search_request, $search){
                $query->where(function($query) use($search_request, $search){
                    foreach($search as $key => $value) {
                        if (in_array($key, $this->complainRepository->getFieldsSearchable())) {
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
            ->when(!is_null($category), function ($query) use($category){
                $query->where("complains.complain_category_id", $category);
            })
            ->when(!is_null($priority), function ($query) use($priority){
                $query->where("complains.priority", ucfirst($priority));
            })
                ->when(!is_null($status), function ($query) use($status){
                $query->where("complains.status", $status);
            });

        $columns = $this->complainRepository->getTableColumns();
        array_push($columns, "users.surname", "users.othernames", "users.phone", "users.email");
/*
 *

Action: <div class="datatable-actions"> <div class="text-center"> <div class="dropdown"> <button  class="btn btn-primary dropdown-toggle button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> <button [hidden]="roleId != 3" (click)="getComplaint(data.id)" data-toggle="modal" data-target="#editComplaint"  id="view__ {{complain_id}}" type="button" > View</button> <button class="dropdown-item" id="update__ {{complain_id}}" type="button"> Update </button> <button  class="dropdown-item" (click)="getComplaint(data.id)" data-toggle="modal" 	data-target="#deleteComplaint" id="delete__ {{complain_id}}" type="button"> Delete </button> </div> </div> </div> </div>

 */
        return $datatableService->dataTable2($request, $builder, [
            '*',
            "user" => function(Complain $complain){
            return $complain->user()->exists() ? $complain->user->surname." ".$complain->user->othernames : null;
            },
            "priority" => function(Complain $complain)
            {
                if ($complain->priority == strtolower("high"))   return "<span class='badge badge-danger' >$complain->priority</span>";
                if ($complain->priority == strtolower("medium"))   return "<span class='badge badge-warning' >$complain->priority</span>";
                if ($complain->priority == strtolower("low"))   return "<span class='badge badge-success' >$complain->priority</span>";
            },
            "status" => function(Complain $complain)
            {
                if ($complain->status == strtolower("open"))   $status = "<span class='badge badge-info'> Open </span>";
                if ($complain->status == strtolower("active"))   $status = "<span class='badge badge-success'> Active </span>";
                if ($complain->status == strtolower("closed"))   $status = "<span class='badge badge-danger'> Closed </span>";

                return$status;
            },
            "file_url" => function(Complain $complain){
                return $complain->file != null ? Storage::url('complainImages/' .$complain->file) : null;
            },
            "date_created" => function(Complain $complain){
                return date('d/m/y H:i:s', strtotime($complain->created_at));
            },
            "complain_category" => function(Complain $complain)
            {
                return $complain->complainCategory->name ?? null;
            },
            'action' => function (Complain $complain) {
                $role_id = auth()->user()->roles[0]->id;
                $role = $role_id != 3 ? "true" : "false";
                return "  <div class='datatable-actions'>
                            <div class='text-center'>
                                <div class='dropdown'>
                                    <button  class='btn btn-primary dropdown-toggle button' type='button' id='dropdownMenuButton'
                                     data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        Actions
                                    </button>
                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                        <button hidden=". $role ."class='dropdown-item'  id='view__".$complain->id."'
                                        type='button' >
                                            View
                                        </button>
                                        <button class='dropdown-item' id='update__".$complain->id."' type='button'>
                                            Update
                                        </button>
                                        <button  class='dropdown-item' (click)='getComplaint(data.id)' data-toggle='modal'
                                            data-target='#deleteComplaint' id='delete__".$complain->id."' type='button'>
                                            Delete
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
     * Display a listing of the Invoice based on a particular user.
     * GET|HEAD /complains_per_user/{user_id}
     *
     * @param Request $request
     * @param user_id
     * @return Response
     */
    public function userIndex(Request $request, $user_id)
    {
        $search = $request->get('search');
        $estate_id = $request->get('estate_id');
        $invoices = $this->complainRepository->paginateViewBasedOnUser('20', ['*'], $search, $estate_id, $user_id);

        return $this->sendResponse(ComplainAPIResource::collection($invoices)->response()->getData(true), 'Invoices retrieved successfully');
    }

    /**
     * Store a newly created Complain in storage.
     * POST /complains
     *
     * @param CreateComplainAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateComplainAPIRequest $request, UploadService $uploadService)
    {
        $user = Auth::user();
        $ticket_id = Complain::query()->orderBy('created_at', 'DESC')->first()->id ?? 0;
        $ticket_id = "".str_pad($ticket_id+1, 5, '0', STR_PAD_LEFT);

        if ($request->has('file') && $request->file != null){
            $imageUploadAction = $uploadService->uploadDocBase64($request->file, "complainImages/");
            if($imageUploadAction['status'] === false){
                $message = "Only images and PDF are supported.!";
                $statuscode = 400;
                return $this->sendError($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
        } else {
            $filename = null;
        }
        $complain_category = ComplainCategory::find($request->complain_category_id);
        $request->merge(['user_id' => $user->id, 'estate_id' => $user->estate_id,
                         'ticket_no' => $ticket_id, 'status' => "active",
                         'file' => $filename]);
        $input = $request->all();

        $user = \request()->user();
        $estate = Estate::query()
                    ->find($user->estate_id);
        $settings = Setting::query()
                    ->where('estate_id', $user->estate_id)
                    ->where('name', 'front_end_url')
                    ->first();
        if (!empty($complain_category->email) and !is_null($complain_category->email))
        {
            $details = [
                "subject" => "Raised complaint",
                "name" => "Administrator",
                "message" => "{$user->surname} {$user->othernames} has a complain as regards {$complain_category->name}.",
                "email" => $complain_category->email,
                "url" => "https://vgcpora.baloshapps.com/auth/login",
                "button_text" => "Login to view Complain",
                "from" => $estate->mail_slug,
            ];
            $email = new GeneralMail($details);
            Mail::to($details['email'])->queue($email);
        }
        $complain = $this->complainRepository->create($input);

        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain sent successfully');
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
    public function update($id, UpdateComplainAPIRequest $request, UploadService $uploadService)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        if ($request->has('file') && $request->file != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->file, "estateImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
//            return $filename;
            $uploadService->deleteImage($complain->imageName, "complainImages/");
        } else {
            $filename = $complain->imageName;
        }
        $request->merge(['file' => $filename]);

        $input = $request->all();
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

    public function closeComplain(Request $request, $id)
    {
        /** @var Complain $complain */
        $complain = $this->complainRepository->find($id);

        if (empty($complain)) {
            return $this->sendError('Complain not found');
        }

        $complain->status = "closed";
        $complain->save();
        return $this->sendResponse(new ComplainAPIResource($complain), 'Complain closed successfully');

    }
}
