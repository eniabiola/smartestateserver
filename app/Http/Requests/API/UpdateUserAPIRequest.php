<?php

namespace App\Http\Requests\API;

use App\Models\User;
use Illuminate\Validation\Rule;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserAPIRequest extends APIRequest
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
        $rules = User::$rules;
        $custom_rules = ['email' => 'required','string','max:255',
            Rule::unique('users')->ignore($this->route('id'), 'id')];
        return array_merge($rules, $custom_rules);
    }
}
