<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Http\Resources\UserResource;
use App\Models\Estate;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
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
            if ($request->get('estate_id') == null) return $this->sendError("What estate residents will you love to see");
            $estate_id = $request->get('estate_id');
        } else {
            $estate_id = \request()->user()->estate_id;
        }


        $users = User::query()
           ->where('estate_id', $estate_id);
        $users = $this->userRepository->searchFields($users, $request->search);

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
    public function store(CreateUserAPIRequest $request, UtilityService $utilityService)
    {
        $request->merge(['password' => bcrypt($request->password)]);
        $input = $request->all();

        if ($request->has('estateCode'))
        {
            $estate_id = Estate::where('estateCode', $request->estateCode)->first()->id;
            $input['estate_id'] = $estate_id;
        }
        $user = $this->userRepository->create($input);
        $user->assignRole($request->role_id);
//
//        $input['user_id'] = $user->id;

        //TODO: Send a queued mail to the user that they have been created on this platform
        return $this->sendResponse(new UserResource($user), 'User saved successfully');
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

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
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
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
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
        $this->validate($request, [
            'id' => 'required|exists:users,id'
        ]);
         return $this->sendResponse(new UserResource($this->userRepository->toggleStatus($request->id)), "User status successfully toggled.");
    }
}
