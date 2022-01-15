<?php

namespace App\Http\Requests\API;

use App\Models\Role;
use InfyOm\Generator\Request\APIRequest;

class UpdateRoleAPIRequest extends APIRequest
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
            'name' => 'required|string|max:255,unique:roles,name,'.$this->route('id'),
            'components' => 'nullable|array|min:1',
            'components.*.comp' => 'nullable|string',
            'components.*.status' => 'nullable|in:true,false'
        ];
    }
}
