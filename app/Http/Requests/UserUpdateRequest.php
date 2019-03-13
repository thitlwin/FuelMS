<?php

namespace PowerMs\Http\Requests;

use PowerMs\Http\Requests\Request;

class UserUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',            
            'email'=>'required|email',
            'phone'=>'required',
            'city_code'=>'required|alpha',
            'nrc_number'=>'required|min:6',            
            'password'=>'required|min:6'         
        ];  
    }
}
