<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\AuthenticationRegisterRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\User;

class AuthenticationController extends BaseController
{
    public function adminRegister(AuthenticationRegisterRequest $request)
    {

        //Request is valid, create new user
        $user = User::create([
            'surname' => $request->surname,
            'othernames' => $request->othernames,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole('superadministrator');


        //User created, return success response
        return $this->successResponse('User created successfully', Response::HTTP_OK, $user);
    }


    public function residentRegister(AuthenticationRegisterRequest $request)
    {

        //Request is valid, create new user
        $user = User::create([
            'surname' => $request->surname,
            'othernames' => $request->othernames,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole('superadministrator');


        //User created, return success response
        return $this->successResponse('User created successfully', Response::HTTP_OK, $user);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
//            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        //Token created, return with success response and jwt token
        $user = User::query()->where('email', $request->email)->first();
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }
}
