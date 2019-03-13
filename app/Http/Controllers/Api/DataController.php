<?php

namespace PowerMs\Http\Controllers\Api;

use PowerMs\MyLibs\Models\Customer;
use Illuminate\Http\Request;
use PowerMs\Http\Controllers\Api\ApiController;
use PowerMs\MyLibs\Repositories\DeviceRepository;
use PowerMs\MyLibs\Repositories\DeviceDetailRepository;
use PowerMs\User;
use PowerMs\Mylibs\Models\Device;
use PowerMs\MyLibs\Repositories\SettingRepository;


class DataController extends ApiController
{
    protected $deviceRepo;
    protected $deviceDetailRepo;
    protected $settingRepo;
    function __construct(DeviceRepository $deviceRepo,DeviceDetailRepository $deviceDetailRepo,SettingRepository $settingRepo)
    {
        $this->deviceRepo = $deviceRepo;
        $this->deviceDetailRepo = $deviceDetailRepo;
        $this->settingRepo = $settingRepo;
    }

    public function updateDevice(Request $request)
    {
        $locale=request()->header('LanguagePref');
        \App::setlocale($locale); 

        $data=$request->all();
        try{
             $device=$this->deviceRepo->update($data,$request->id); 

           }catch(\Exception $e)
            {
              $err_msg=$e->getMessage();
              return $this->respondError($err_msg);
            }

        return $this->respondSuccess('success', $device);
    }

    public function updateDeviceDetail(Request $request)
    {
        $locale=request()->header('LanguagePref');
        \App::setlocale($locale); 

        $data=$request->all();
        try{
             $device=$this->deviceDetailRepo->update($data,$request->id); 

           }catch(\Exception $e)
            {
              $err_msg=$e->getMessage();
              return $this->respondError($err_msg);
            }

        return $this->respondSuccess('success', $device);
    }

    public function getDevices(Request $request)
    {
        $locale=request()->header('LanguagePref');
        \App::setlocale($locale); 
        $device_id = $request->device_id;
        $user_id = $request->user_id;
        $location_id = $request->location_id;
        
        $settings = \DB::select('select * from setting where user_id = ?', [$user_id]);
        if(count($settings) > 0)
        {
             if(count($settings[0]->selected_dashboard_state) > 0)
             {
                 $data_location=\DB::select('select id,location_name as name from locations where id = ?', [$location_id]);
                 $data_device=\DB::select('select id,name from devices where id = ?', [$device_id]);
                 if(count($data_location) > 0){
                     $data['location']=$data_location[0];
                 }else{
                     $data['location']=["id" => "0" , "name" => "All"];
                 }

                 if(count($data_device) > 0){
                      $data['device']=$data_device[0];
                 }else{
                     $data['device']=null;
                 }
                
                 $states=json_encode($data);
                 $updatState="UPDATE setting SET selected_dashboard_state='$states' WHERE user_id=$user_id";
                 $updatState=\DB::update($updatState);
             }else{

                $data['selected_dashboard_state'] ='{"location":{"id":0,"name":"All"},"device":{"id":1,"name":"None"}}';
                $create_selected_state=$this->settingRepo->update($data,$settings[0]->id);
             }
        }else{
            
            $data['user_id']=$user_id ;
            $data['selected_dashboard_state'] ='{"location":{"id":0,"name":"All"},"device":{"id":1,"name":"None"}}';
            $create_selected_state=$this->settingRepo->create($data);
        }
        
        $json_device="SELECT devicePref from setting where user_id=$user_id";
        $res=\DB::select($json_device);
        if(count($res)>0)
        {
            $rep_setting=$res[0]->devicePref;
            $res=(array)json_decode($rep_setting);
            if(count($res) > 0){
                $selected_devices=array_except($res,'id');
            }else{
                 $selected_devices=[ "0" => "A","1" => "VLL","2" => "W","3" => "VA","4" => "PF","5" => "F","6" => "FVAh","7" => "PD"];
            }
        
        }else{
            $selected_devices=[ "0" => "A","1" => "VLL","2" => "W","3" => "VA","4" => "PF","5" => "F","6" => "FVAh","7" => "PD"];
        }
        foreach ($selected_devices as $key => $value) {
           $sql="SELECT unit_name,id As unit_value ,min,max FROM ranges where unit_name='$value'";
           $selected_ranges[]=\DB::select($sql);
        }
        foreach ($selected_ranges as $key => $value) {
            $selected_values[]=$value[0];
        }
        $maxId="SELECT max(id) as maxId FROM device_detail WHERE device_id=$device_id";
        $id=\DB::select($maxId);
        $max_id=$id[0]->maxId;
        foreach ($selected_values as $key => $value) {
           $sql="SELECT $value->unit_name FROM  device_detail WHERE device_detail.device_id=$device_id AND device_detail.id=$max_id";
           $selected_dev[]=\DB::select($sql);
        }
        foreach ($selected_dev as $key => $value) {
                  $dev[]=$value[0];

        }
        foreach($dev as $row)
            {
                foreach($row as $key => $val)
                {
                    $valtt[]=$val;
                }
            }
        foreach ($valtt as $key => $value) {
                $selected_values[$key]->unit_value=$value;

        }

        foreach ($selected_values as $key => $value) {

            if($value->unit_name == 'FWh')
            {
                if($value->unit_value < 1000 ){
                    $selected_values[$key]->unit_name = $value->unit_name.' (W)';
                }else{
                        if($value->unit_value >= 1000 and $value->unit_value <1000000){
                        $selected_values[$key]->unit_value = round(intval($value->unit_value)/1000,2);
                        $selected_values[$key]->min = round(intval($value->min)/1000,2);
                        $selected_values[$key]->max = round(intval($value->max)/1000,2);
                        $selected_values[$key]->unit_name = $value->unit_name.' (kW)';
                    }
                    if($value->unit_value >= 1000000 and $value->unit_value <1000000000){
                        $selected_values[$key]->unit_value = round(intval($value->unit_value)/1000000,2);
                        $selected_values[$key]->min = round(intval($value->min)/1000000,2);
                        $selected_values[$key]->max = round(intval($value->max)/1000000,2);
                        $selected_values[$key]->unit_name = $value->unit_name.' (MW)';
                    }
                    if($value->unit_value >= 1000000000){
                        $selected_values[$key]->unit_value = round(intval($value->unit_value)/1000000000,2);
                        $selected_values[$key]->min = round(intval($value->min)/1000000000,2);
                        $selected_values[$key]->max =round (intval($value->max)/1000000000,2);
                        $selected_values[$key]->unit_name = $value->unit_name.' (GW)';
                    }
                }
            }
        }
        return $this->respondSuccess("success",$selected_values);
    }


    public function sendMailToAdmin(Request $request)
    {
        $sender_email=env('MAIL_SENDER_ADDRESS');
        $data=$request->all();
        $receivers= User::where('user_type_id',$request->receiver_type_id)->pluck('email')->toArray();         
        if(count($receivers)>0){
            // dd($data,$receivers);
            \Mail::send('email.notification',['data'=>$data], function ($message) use ($data,$receivers,$sender_email) {
              $message->subject('Alert Mail from '.$data['device_name'])
                      ->to($receivers)
                      ->from($sender_email);
            });
            return $this->respondSuccess("success",[]);
        }
        return $this->respondError('There is no receiver.');
    }

    public function insertDeviceData(Request $request)
    {
        $locale=request()->header('LanguagePref');
        \App::setlocale($locale); 
        $device = Device::where('name',$request->device_name)->first();
        if(isset($device))
        {
            $data=array_except($request->all(),'device_name');
            $electrical_data=array_merge($data,['device_id'=>$device->id]);            
            try{
                 $res=$this->deviceDetailRepo->create($electrical_data); 
               }catch(\Exception $e)
                {
                  $err_msg=$e->getMessage();
                  return $this->respondError($err_msg);
                }
            return $this->respondSuccess('success', $res);
        }else
            return $this->respondError("This device name does not exist at server.");        
    }

    public function getDevicesByLocation(Request $request)
    {
        $devices=$this->deviceRepo->getDevicesByLocation($request->locationId);
        if(count($devices)>0)
            return $this->respondSuccess('success',$devices);
        return $this->respondError('There is no device at this location.');
    }

    public function getDevicesByDashboardLocation(Request $request)
    {
        $devices = \DB::select('select id as device_id,name from devices where location_id = ?', [$request->locationId]);
        if(count($devices)>0)
            return $this->respondSuccess('success',$devices);
        return $this->respondError('There is no device at this location.');
    }

}