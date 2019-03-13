<?php

namespace PowerMs\Mylibs\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardSetting extends Model
{
	public $table='dashboard_setting';
     public $fillable=['user_id','selected_device_id','db_update_second','interval_chart_second','chart_width','chart_height','minor_ticks','red_from','red_to','yellow_from','yellow_to'];
}

