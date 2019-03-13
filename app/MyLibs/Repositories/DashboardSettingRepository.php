<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\MyLibs\Models\DashboardSetting;
use PowerMs\MyLibs\Repositories\BaseRepository;


class DashboardSettingRepository extends BaseRepository {

	protected $model;
	public function __construct(DashboardSetting $model)
	{
		$this->model = $model;
	}

	public function getByUserId()
	{
		$res=$this->model->where('user_id',\Auth::id())->get();
		if(count($res) <= 0){
			return $res=[ 

				        "db_update_second" => 10,
				        "interval_chart_second" => 5,
				        "chart_width" => 500,
				        "chart_height" => 150,
				        "minor_ticks" => 5,
				        "red_from" => 90,
				        "red_to" => 100,
				        "yellow_from" => 75,
				        "yellow_to" => 90 ];
		}
        return $res[0];
	}	

}