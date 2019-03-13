<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\MyLibs\Models\Setting;
use PowerMs\MyLibs\Repositories\BaseRepository;


class SettingRepository extends BaseRepository {

	protected $model;
	public function __construct(Setting $model)
	{
		$this->model = $model;
	}	

 	public function getByUserId($id)
    {
        $res=$this->model->where('user_id',$id)->get();
        return $res;
    }

	public function getDeviceSettings()
	{
		$data=$this->model->where('user_id',\Auth::user()->id)->get();
    	return $data;	
	}

	public function getSetting()
	{
		$res=$this->model->where('user_id',\Auth::user()->id)->get();
        return $res;
	}

	public function getReportSetting()
	{
		$res=$this->model->select('reportPref')->where('user_id',\Auth::user()->id)->get();
		if(count($res)>0)
        {
            $rep_setting=$res[0]->reportPref;
            $res=(array)json_decode($rep_setting);
            $res=array_except($res,'id');
            return array_values($res);
        }
	}

	public function getMeasureUnitForW()
	{
		$res=$this->model->select('unitPref')->where('user_id',\Auth::user()->id)->get();
		if(count($res)>0)
        {
        	if(count($res[0]->unitPref) > 0){
	            $rep_setting=$res[0]->unitPref;
	            $res=(array)json_decode($rep_setting);            
	            return $res['w_report_unit'];
	         }
        }
        return 'W';//default
	}

	public function getMeasureUnitForWh()
	{
		$res=$this->model->select('unitPref')->where('user_id',\Auth::user()->id)->get();
		if(count($res)>0)
        {
        	if(count($res[0]->unitPref) > 0){
	            $rep_setting=$res[0]->unitPref;
	            $res=(array)json_decode($rep_setting);            
	            return $res['wh_report_unit'];
	          }
        }
        return 'W';//default
	}

	public function getDataExportColumn()
	{
		$res=$this->model->select('exportColumnPref')->where('user_id',\Auth::user()->id)->get();		
		if(count($res)>0)
        {
            $setting=$res[0]->exportColumnPref;
            $res=(array)json_decode($setting); 
            return $res;
        }
        return [];//default
    }
    
	public function getMeasureUnitForDashboard()
	{
		$res=$this->model->select('unitPref')->where('user_id',\Auth::user()->id)->get();

		if(count($res)> 0)
        {
        	if(isset($res[0]->unitPref)){
	        	$rep_setting=$res[0]->unitPref;
	            $res=(array)json_decode($rep_setting); 
	            return $res['dashboard_unit'];
        	}else{
        		 return 'W';
        	}
        }
        return 'W';
	}
}