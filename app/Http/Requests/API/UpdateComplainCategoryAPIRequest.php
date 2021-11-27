<?php

namespace App\Http\Requests\API;

use App\Models\ComplainCategory;
use Illuminate\Validation\Rule;
use InfyOm\Generator\Request\APIRequest;

class UpdateComplainCategoryAPIRequest extends APIRequest
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
        return
        ['name' => 'required','string','max:20',
            Rule::unique('complain_categories')->ignore($this->route('id'), 'name')];;
    }
}
