<?php

namespace PowerMs\Http\Requests;

use PowerMs\Http\Requests\Request;

class RangeRequest extends Request
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
            'unit_name'=>"required | unique:ranges,unit_name",
            'min'=>"required",
            'max'=>"required",
        ];
    }
}
