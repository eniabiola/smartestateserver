<?php

namespace App\Http\Requests\API;

use App\Models\Billing;
use InfyOm\Generator\Request\APIRequest;

class UpdateBillingAPIRequest extends APIRequest
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
        $rules = Billing::$rules;
        $rules['name'] = 'required|string|max:100|unique:billings,name,'.$this->route('billing');
        return $rules;
    }
}
