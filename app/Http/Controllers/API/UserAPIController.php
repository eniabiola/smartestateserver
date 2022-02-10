<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Http\Resources\UserResource;
use App\Mail\UserWelcomeMail;
use App\Models\Estate;
use App\Models\Resident;
use App\Models\Role;
use App\Models\User;
use App\Repositories\ResidentRepository;
use App\Repositories\UserRepository;
use App\Services\DatatableService;
use App\Services\UploadService;
use App\Services\UtilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Response;


/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        if (Auth::user()->hasrole('superadministrator'))
        {
            $estate_id = $request->get('estate_id');
            if ($request->get('estate_id') == null)
            {
                $estate_id = Estate::query()->distinct()->first()->id;
            }
        } else {
            $estate_id = \request()->user()->estate_id;
        }


        $users = User::query()
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', '!=', 'resident')
            ->where('users.estate_id', $estate_id)
            ->select('users.*');
        // $users = $this->userRepository->searchFields($users, $request->search);
        return $this->sendResponse(UserResource::collection($users->paginate(20))->response()->getData(true), 'Users retrieved successfully');

        return $this->sendResponse(UserResource::collection($users->get()), 'Users retrieved successfully');
    }


    public function indexDataTable(Request $request, DatatableService $datatableService)
    {
        $date_from = $request->query('date_from') != "null" && $request->query('date_from') != "" ? $request->query('date_from') : null;
        $date_to = $request->query('date_to') != "null" && $request->query('date_to') != "" ? $request->query('date_to') : null;
        $street = $request->query('guest_name') != "null" && $request->query('guest_name') != "" ? $request->query('date_from') : null;

        if (Auth::user()->hasrole('superadministrator'))
        {
            if ($request->get('estate_id') == null) return $this->sendError("What estate visitorPasss will you love to see");
            $estate_id = $request->get('estate_id');
        } else {
            $estate_id = \request()->user()->estate_id;
        }
        $search = [];
        $processedRequest = $datatableService->processRequest($request);
        $search_request = $processedRequest['search'];

        $search = $this->userRepository->getDataTableSearchParams($processedRequest, $search_request);

        $builder = $this->userRepository->builderBasedOnRole('users.estate_id', $request->get('estate_id'))
            ->leftJoin('estates', 'estates.id', 'users.estate_id')
            ->leftJoin('residents', 'residents.user_id', 'users.id')
            ->join('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->select('users.*',
                'estates.name AS estates__dot__name',
                'roles.name AS roles__dot__name')
            ->when($search_request != null, function ($query) use($search_request, $search){
                $query->where(function($query) use($search_request, $search){
                    foreach($search as $key => $value) {
                        if (in_array($key, $this->userRepository->getFieldsSearchable())) {
                            $query->orWhere($key, 'LIKE', '%'.$value.'%');
                        }
                    }
                });
            })
            ->when(!is_null($date_from) && !is_null($date_to), function ($query) use($date_from, $date_to){
                $from = Carbon::parse($date_from)->startOfDay()->format("Y-m-d H:i:s");
                $to = Carbon::parse($date_to)->endOfDay()->format("Y-m-d H:i:s");
                $query->whereBetween("users.created_at", [$from, $to]);
            })
            ->when(!is_null($street), function ($query) use($street){
                $query->whereBetween("residents.street_id", $street);
            });

        $columns = $this->userRepository->getTableColumns();
        array_push($columns, "users.surname", "users.othernames", "users.phone", "users.email");

        return $datatableService->dataTable2($request, $builder, [
            '*',
            'role_id' => function (User $user) {
                return $user->roles[0]->id;
            },
            'role' => function (User $user)
            {
//                return $user->roles[0]->name;
                if ($user->roles[0]->name == "superadministrator") return  "<span class='badge badge-pill badge-danger'>".$user->roles[0]->name."</span>";
                if ($user->roles[0]->name == "administrator") return  "<span class='badge badge-pill primary'>".$user->roles[0]->name."</span>";
                if ($user->roles[0]->name == "superadministrator") return  "<span class='badge badge-pill success'>".$user->roles[0]->name."</span>";
                if ($user->roles[0]->name == "resident" ||$user->roles[0]->name == "security" ) return  "<span class='badge badge-pill primary'>".$user->roles[0]->name."</span>";
            },
            'name' => function(User $user){
                return $user->surname. " ".$user->othernames;
            },
            'action' => function (User $user) {
                return "
                <div class='datatable-actions'>
                    <div class='text-center'>
                        <div class='dropdown'>
                            <button  class='btn btn-primary dropdown-toggle button' type='button'
                            id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                Actions
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <button class='edit-card dropdown-item' id='update__$user->id' type='button'>
                                    Update User
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
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request, UtilityService $utilityService, UploadService $uploadService)
    {
        $request->merge(['password' => bcrypt($request->password)]);

        if ($request->has('imageName') && $request->imageName != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->imageName, "userImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
        } else {
            $filename = "default.jpg";
        }

        if ($request->has('estateCode'))
        {
            $estate = Estate::where('estateCode', $request->estateCode)->first();
            $request->merge(['estate_id' => $estate->id]);
        }
        $request->merge(['imageName' => $filename, 'email_verified_at' => date("Y-m-d H:i:s")]);
        $input = $request->all();

        $user = $this->userRepository->create($input);
        $user->assignRole($request->role_id);
        $role = Role::query()->find($request->role_id);

        $details = [
            "name" => $request->surname. " ".$request->othernames,
            "estate_name" => $estate->name,
            "email" => $request->email,
            "message" => "An account has been created for you as a $role->name of $request->name estate",
            "password" => $request->password,
            "url"      => url('/')."/auth/login",
            "from"     => $estate->mail_slug
        ];

        $email = new UserWelcomeMail($details);
        Mail::to($details['email'])->queue($email);

        return $this->sendResponse(new UserResource($user), 'User account successfully created');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAPIRequest $request, ResidentRepository $residentRepository, UploadService $uploadService)
    {
//        return $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if ($request->has('imageName') && $request->imageName != null){
            $imageUploadAction = $uploadService->uploadImageBase64($request->imageName, "userImages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            }
            $filename = $imageUploadAction['data'];
            $uploadService->deleteImage($user->imageName, "userImages/");
        } else {
            $filename = $user->imageName;
        }
        $request->merge(['imageName' => $filename]);

        $input = $request->all();


        $user = $this->userRepository->update($input, $id);
        if ($user->hasRole('resident')){
//            $resident = $residentRepository->find($user->id);
            $resident = Resident::where('user_id', $user->id)->first();
            $updateResident = $request->only(['meterNo', 'houseNo', 'street_id']);
            $residentRepository->update($updateResident, $resident->id);
        }
        return $this->sendResponse(new UserResource($user), 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendSuccess('User deleted successfully');
    }


    public function toggleStatus(Request $request)
    {
        $user = User::find($request->id);
        $adminUser = Auth::user();
        $status = $user->isActive;
        $message_status = $status == true ? "deactivated" : "activated";
        if ($adminUser->hasRole('administrator') && $adminUser->estate_id == $user->estate_id)
        {
            $this->validate($request, [
                'id' => 'required|exists:users,id'
            ]);
            return $this->sendResponse(new UserResource($this->userRepository->toggleStatus($request->id)), "User has been successfully {$message_status}.");
        }
        return $this->sendError("You are unable to perform this operation", 401);
    }
}
