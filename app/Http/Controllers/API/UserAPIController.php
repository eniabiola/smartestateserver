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
use App\Services\UploadService;
use App\Services\UtilityService;
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
        $users = $this->userRepository->searchFields($users, $request->search);
//        return $this->sendResponse(UserResource::collection($users->paginate(20))->response()->getData(true), 'Users retrieved successfully');

        return $this->sendResponse(UserResource::collection($users->get()), 'Users retrieved successfully');
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
            "url"      => url('/')."/auth/login"
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
        if ($adminUser->hasRole('administrator') && $adminUser->estate_id == $user->estate_id)
        {
            $this->validate($request, [
                'id' => 'required|exists:users,id'
            ]);
            return $this->sendResponse(new UserResource($this->userRepository->toggleStatus($request->id)), "User status successfully toggled.");
        }
        return $this->sendError("You are unable to perform this operation", 401);
    }
}
