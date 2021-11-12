<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleModuleAccessStoreRequest extends FormRequest
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
            'module_access' => 'required|integer|exists:module_accesses,id',
            'roles' => 'required|array|min:1',
            'roles.*' => 'required|integer|exists:roles,id'
        ];
    }
}
