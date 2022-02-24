<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{

    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return redirect()->to(config("url_constants.front_end_url").'/auth/verification-expired');
//            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to(config("url_constants.front_end_url"));
    }

    public function resend(Request $request) {
        $input = $request->validate([
            "email" => "required|email:rfc,dns|exists:users,email"
        ], ['email.exists' => 'Your email was not found.']);
        $user = User::query()->where('email', $request->email)->first();
        if ($user->email_verified_at != null) {
            return response()->json(["msg" => "Email already verified."], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
