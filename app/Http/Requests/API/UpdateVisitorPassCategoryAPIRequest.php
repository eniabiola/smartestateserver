<?php

namespace App\Http\Requests\API;

use App\Models\VisitorPassCategory;
use InfyOm\Generator\Request\APIRequest;

class UpdateVisitorPassCategoryAPIRequest extends APIRequest
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
        $rules = VisitorPassCategory::$rules;
        $rules['name'] = 'required|string|max:255|unique:visitor_pass_categories,name,'.$this->route('id');
        $rules['prefix'] = 'nullable|string|max:10|unique:visitor_pass_categories,prefix,'.$this->route('id');

        return $rules;
//        return array_merge($rules, $customArray);
    }
}
