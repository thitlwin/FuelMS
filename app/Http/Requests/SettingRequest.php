<?php

namespace PowerMs\Http\Requests;

use PowerMs\Http\Requests\Request;

class SettingRequest extends Request
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
             'user_id'=>'required',
            'devicePref'=>'required|min:0|max:10',
            'reportPref'=>'required|min:0|max:10',
        ];
    }
}
