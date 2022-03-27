<?php

namespace App\Http\Requests\API;

use App\Models\User;
use InfyOm\Generator\Request\APIRequest;

class CreateUserAPIRequest extends APIRequest
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

        $customRule =
            [
            'role_id' => 'required|exists:roles,id',
             'estateCode' => 'sometimes|nullable|exists:estates,estateCode',
             'password' => 'required|confirmed|min:6'
        ];
        return array_merge(User::$rules, $customRule);
    }
}
