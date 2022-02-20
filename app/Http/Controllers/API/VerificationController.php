<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{

    public function verify($user_id, Request $request) {

        $user = User::findOrFail($user_id);

        $settings = Setting::query()
            ->where("estate_id", $user->estate_id)
            ->where('name', 'front_end_url')
            ->first();
        $url = $settings ? $settings->value : null;

        if (!$request->hasValidSignature()) {
            return redirect()->to($url.'/auth/verification-expired');
//            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to($url);
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
