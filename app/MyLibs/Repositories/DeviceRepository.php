<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\MyLibs\Models\Device;
use PowerMs\MyLibs\Repositories\BaseRepository;

class DeviceRepository extends BaseRepository {

	protected $model;
	public function __construct(Device $model)
	{
		$this->model = $model;
	}
	public function getalldata()
    {
    	$device=\DB::select('select devices.id, devices.location_id, devices.name, locations.location_name from devices inner join locations on devices.location_id=locations.id ');
    	return $device;
    }

    public function getAllDeviceIDs()
    {
        $ids=[];
    	$res=$this->model->get();
        if(count($res)>0)
            $ids=array_pluck($res,'id');
    	return $ids;
    }

    public function getDevicesByLocation($location_id)
    {
        $devices=[];
        $res=$this->model->select('id','name')->where('location_id',$location_id)->get();
        if(count($res)>0)
            return $res;         
        return $devices;
    }

}