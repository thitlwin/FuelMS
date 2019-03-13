<?php

namespace PowerMs\Http\Requests;

use PowerMs\Http\Requests\Request;

class PasswordUpdateRequest extends Request
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
            'current_password'=>'required|min:6',            
            'new_password'=>'required|min:6',
            'confirm_password'=>'required|min:6|same:new_password',
        ];
    }
}
