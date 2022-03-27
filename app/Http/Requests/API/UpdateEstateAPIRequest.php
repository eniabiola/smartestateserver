<?php

namespace App\Http\Requests\API;

use App\Models\Estate;
use Illuminate\Validation\Rule;
use InfyOm\Generator\Request\APIRequest;

class UpdateEstateAPIRequest extends APIRequest
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

        $rules = Estate::$rules;
        $custom_rules = ['name' => 'required','string','max:100',
            Rule::unique('estates')->ignore($this->route('id'), 'name')];

        return array_merge($rules, $custom_rules);
    }
}
