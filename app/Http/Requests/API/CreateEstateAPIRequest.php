<?php

namespace App\Http\Requests\API;

use App\Models\Estate;
use InfyOm\Generator\Request\APIRequest;

class CreateEstateAPIRequest extends APIRequest
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
        $rules['name'] = 'required|string|max:100|unique:estates,name';
        $rules['email'] = 'required|string|max:100|unique:users,email';

        return $rules;

    }
}
