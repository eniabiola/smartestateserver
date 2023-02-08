<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\PushNotificationEvent;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\AuthenticationRegisterRequest;
use App\Http\Resources\RoleResource;
use App\Jobs\SendPasswordResetEmail;
use App\Mail\PasswordResetEmail;
use App\Models\PasswordReset;
use App\Models\Resident;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthenticationController extends BaseController
{
    public $url;

    public function __construct()
    {
        if (Auth::check())
        {
            $settings = Setting::query()
                ->where("estate_id", Auth::user()->estate_id)
                ->where('name', 'front_end_url')
                ->first();
            $this->url = $settings ? $settings->value : null;
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Request is validated
        //Create token
        try {
            $myTTL = 1200; //minutes

            JWTAuth::factory()->setTTL($myTTL);
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->sendError('Login credentials are invalid.', 'Login credentials are invalid.', 400);
            }
        } catch (JWTException $e) {
            return $this->serverError('Could not create token.');
        }

        $user = User::query()->where('email', $request->email)->first();
        if ($user->isActive == false) return $this->sendError([], 'Your account needs approval by the Estate Administrator.', 400);

        $userToken = ['token' => $token, 'expires_at' => 30*$myTTL];
        $data = [
            'user_token' => $userToken,
            'user' => $this->getUserData($user)
        ];
        $message = "User Logged In";
        return $this->sendSuccess($data,'User Logged In', Response::HTTP_OK);
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

        $user = request()->user();
        $data = [
            'user_token' => $request->token,
            'user' => $this->getUserData($user)
        ];

        return $this->sendSuccess($data,'User details', Response::HTTP_OK);
    }

    public function getUserData($user)
    {
        $role_id = $user->roles->pluck('id');
        $role = Role::find($role_id);

        $general_info =  [
            'id' => $user->id,
            'name' => $user->firstname." ".$user->othernames,
            'email' => $user->email,
            'phone' => $user->phone,
            "imageName" => $user->imageName != "default.jpg" ? Storage::url('userImages/' .$user->imageName) : \url('/')."/default.jpg",
            'is_active' => $user->isActive,
            'role' => $role,
            'role_access_component' => !empty($role) ? \Opis\Closure\unserialize($role[0]->component) : [],
            'estate' => $user->estate_id == null ? null :[
                'id' => $user->estate_id,
                'name' => $user->estate->name,
                'estate_code' => $user->estate->estateCode,
            ],
            'resident' => $user->resident()->exists() ? $user->resident : null,
        ];

        if ($user->hasRole('resident'))
        {
            $resident = Resident::query()->where('user_id', $user->id)->first();

            $resident_info = [
                // 'resident_id' => $resident->id,
                'house_no' => $resident->houseNo,
                'street' => $resident->street,
                'meter_number' => $resident->meterNo,
            ];
            return array_merge($general_info, $resident_info);
        }
        return $general_info;
    }


    public function resetPassword(Request $request)
    {
        $input = $request->validate([
            "old_password" => "required",
            "password" => "required|confirmed|min:6",
            "password_confirmation" => "required|min:6"
        ]);

        try {
            /** @var User $user */
            $user = auth()->user();
            $hashedPassword = $user->password;
            if (Hash::check($input["old_password"], $hashedPassword)) {
                $user->update([
                    "password" => bcrypt($input["password"])
                ]);
                return $this->sendSuccess($user, "Password changed successfully");
            } else {
                return $this->sendError("Invalid old password");
            }
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage(), $exception);
        }
    }

    public function forgotPassword(Request $request)
    {
        $respMessage = "Invalid Email";
        \request()->validate([
            "email" => "required|email|exists:users,email"
        ], [
            "email.exists" => $respMessage
        ]);

        $email = \request()->input("email");
        $user = User::where("email", $email)->first();

        $token = time() . Str::random(20) . time() . rand(0, 19098987);

        DB::table("password_resets")
            ->insert([
                "email" => $user->email,
                "token" => $token,
                "created_at" => \Carbon\Carbon::now()
            ]);

        //TODO: send message to user to reset email

        $message = "Dear {$user->surname} {$user->othernames}, click on the link below to reset your password" . PHP_EOL;

        $url = config("url_constants.front_end_url")."/auth/reset-password/{$token}";

        $maildata = [
            'name' => $user->surname. " ".$user->othernames,
            'email' => $email,
            'message' => $message,
            'url' => $url
        ];

        $email = new PasswordResetEmail($maildata);
        Mail::to($maildata['email'])->queue($email);
        return $this->sendSuccess(
            [],
            "A password reset email has been sent"
        );


    }

    public function UserResetPassword(Request $request)
    {
        $request->validate([
            "token" => "required|exists:password_resets,token",
            "password" => "required|confirmed|min:6",
            "password_confirmation" => "required|min:6"
        ]);

        $token = $request->token;


        $userToken = PasswordReset::where("token", $token)->first();
        if (is_null($userToken)) {
            return $this->sendError("No User with the token supplied", "No User with the token supplied");
        }

        if (\Carbon\Carbon::now()->gt(Carbon::parse($userToken->created_at)->addHours(1))) {
            return $this->sendError("Token Expire", "Token Expire");
        }

        $user = User::where("email", $userToken->email)->first();
        if (is_null($user)) {
            return $this->sendError("No User with the token supplied", "No User with the token supplied");
        }

        $user->password = bcrypt($request->password);
        //$user->activate_token = null;
        $user->save();

        //remove password reset
        PasswordReset::query()->where("token", $token)->delete();
        return $this->sendSuccess([], "Password Successfully changed");
    }

}
