<?php

namespace App\Http\Requests\API;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Validation\Rule;
use InfyOm\Generator\Request\APIRequest;

class UpdateResidentAPIRequest extends APIRequest
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
        $user_id = Resident::query()->find($this->route('id'));
//        $user_rules = User::$rules;
        $resident_rules = Resident::$rules;
        $custom_rules = [
            'surname' => 'required',
            'othernames' => 'required',
            'phone' => 'required',
            'email' => 'required','string','max:255',
//            Rule::unique('users')->ignore($user_id->user_id, 'email')
        ];


        return array_merge(/*$user_rules, */$resident_rules, $custom_rules);
    }
}
