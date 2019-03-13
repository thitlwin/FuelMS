<?php

namespace PowerMs\MyLibs\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
   public $table="setting";
   public $fillable=['user_id','devicePref','reportPref','unitPref','exportColumnPref','selected_state_w_report','selected_state_wh_report_by_hour','selected_state_wh_report_by_day','selected_state_wh_report_by_month','selected_state_wh_report_by_date_range','selected_dashboard_state'];
}
