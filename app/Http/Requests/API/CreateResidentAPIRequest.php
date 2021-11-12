<?php

namespace App\Http\Requests\API;

use App\Models\Resident;
use App\Models\User;
use InfyOm\Generator\Request\APIRequest;

class CreateResidentAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_rules = User::$rules;
        $resident_rules = Resident::$rules;
        $customRule =
            [
                'password' => 'required|confirmed|min:6'
            ];
        return array_merge($user_rules, $resident_rules);
    }
}
