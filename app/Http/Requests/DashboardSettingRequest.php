<?php

namespace PowerMs\Http\Requests;

use PowerMs\Http\Requests\Request;

class DashboardSettingRequest extends Request
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
            'db_update_second'=>"required",
            'interval_chart_second'=>"required",
            'chart_width'=>"required",
            'chart_height'=>"required",
            'minor_ticks'=>"required",
            'red_from'=>"required",
            'red_to'=>"required",
            'yellow_from'=>"required",
            'yellow_to'=>"required",
        ];
    }
}
