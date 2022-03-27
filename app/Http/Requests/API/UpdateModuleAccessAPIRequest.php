<?php

namespace App\Http\Requests\API;

use App\Models\ModuleAccess;
use InfyOm\Generator\Request\APIRequest;

class UpdateModuleAccessAPIRequest extends APIRequest
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
        return [
            'name' => 'required|string|max:100|unique:module_accesses,name,id'.$this->route('id'),
        ];

        $rules = ModuleAccess::$rules;

        return $rules;
    }
}
