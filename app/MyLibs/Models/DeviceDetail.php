<?php

namespace PowerMs\MyLibs\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
    public $table="device_detail";
    public $fillable=['device_id','A','A1','A2','A3','VLL','VLN','V12','V23','V31','V1','V2','V3','W','W1','W2','W3','VAR','VAR1','VAR2','VAR3','VA','VA1','VA2','VA3','PF','PF1','PF2','PF3','F','FVAh','FWh','FVARh','RVAh','RWh','RVARh','OnH','FRun','RRun','INTR','PD','RD','MaxMD','MaxDM'];
}
