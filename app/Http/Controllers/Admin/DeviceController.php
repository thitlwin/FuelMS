<?php

namespace PowerMs\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PowerMs\MyLibs\Repositories\LocationRepository;
use PowerMs\Http\Controllers\Controller;
use PowerMs\MyLibs\Repositories\DeviceRepository;
use PowerMs\Http\Requests\DeviceRequest;
use Yajra\DataTables\DataTablesServiceProvider;
use PowerMs\MyLibs\Repositories\SettingRepository;
use PowerMs\MyLibs\Repositories\DashboardSettingRepository;

class DeviceController extends Controller
{
    protected $deviceRepo;
    protected $locationRepo;
    protected $settingRepo;
    protected $dashboardSettingRepo;
    public function __construct(DeviceRepository $deviceRepo,LocationRepository $locationRepo,SettingRepository $settingRepo,DashboardSettingRepository $dashboardSettingRepo)
    {                
        $this->deviceRepo=$deviceRepo;
        $this->locationRepo=$locationRepo;
        $this->settingRepo=$settingRepo;
        $this->dashboardSettingRepo=$dashboardSettingRepo;

    }

    public function index()
    {
        $device=$this->deviceRepo->getalldata();
        // dd($device);
    	// $device=$this->deviceRepo->getAll();
         // dd($device);
    	return view('admin.device.index',compact('device'));
    }
    public function create()    
    {
        $location=[];
        $res=$this->locationRepo->getAll();
        foreach ($res as $key => $value) {
           $location[$value->id]=$value->location_name;
        }
    	return view("admin.device.create",compact('location'));
    }

    public function save(Request $request)
    {

    	$data=$request->all();
        
                      
        try{            
            $res=$this->deviceRepo->create($data);
            // dd($res);
        }catch(\Exception $e){            
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }        
        toast()->success('Device has successfully created.');
        \Log::info(\Auth::user()->login_name.' has created device type. id='.$res->id);
        return redirect()->back();     
    }
    public function edit(Request $request)
    { 

        $res=$this->locationRepo->getAll();

         foreach ($res as $key => $value) {
           $location[$value->id]=$value->location_name;
        }
        $device_edit = $this->deviceRepo->getById($request->id);
        // dd($device_edit);

     return view('admin.device.edit',compact('device_edit','location'));

    }
    public function update(Request $request)
    {
      $data=$request->all();        
        try{
            $this->deviceRepo->update($data,$data['id']);
        }catch(\Exception $e){           
            if(strpos($e->getMessage(), 'Duplicate'))
                $err_msg=substr($e->getMessage(), strpos($e->getMessage(), "Duplicate"), strpos($e->getMessage(), "for") - strpos($e->getMessage(), "Duplicate"));
            else
                $err_msg=$e->getMessage();
            toast()->error($err_msg);
            return redirect()->back()->withInput();
        }        
        toast()->success('Device has successfully updated.');
        \Log::info(\Auth::user()->login_name.' has updated device. id='.$data['id']);
        return redirect()->back();

    }
    public function delete(Request $request)
    {
     $id=$request->input('id');              
         try{
            $this->deviceRepo->delete($id);        
        }catch(\Exception $e){
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
        toast()->success('Device  has successfully deleted.');
        \Log::info(\Auth::user()->login_name.' has deleted device. id='.$id);
        return redirect()->back();
    }   

    public function dashboard()
    {
        $auth_user = \Auth::user()->id; $selected_device_id=[];$location_id=[];
                          
        $sql_location="SELECT id as location_id,location_name from locations";
        $locations=\DB::select($sql_location);
        $data['location_id']=0;
        $data['location_name']='All';
        $location[]=$data;
        foreach ($locations as $key => $value) {
            $location[]=$value;
        }
        $sql_setting="SELECT * FROM dashboard_setting where user_id=".\Auth::id()."";
        $setting=\DB::select($sql_setting);
        
        $settings = \DB::select('select * from setting where user_id = ?', [\Auth::id()]);
        
        if(count($settings) > 0)
        {
             if(isset($settings[0]->selected_dashboard_state))
             {
                 $data_state = \DB::select('select selected_dashboard_state from setting where user_id = ?', [\Auth::id()]);
                 $data_decoded = json_decode($data_state[0]->selected_dashboard_state);
                 $location_id = $data_decoded->location->id;
                 if(isset( $data_decoded->device->id))
                 {
                    $selected_device_id = $data_decoded->device->id;
                 }else{
                    $selected_device_id =1;
                 }
                 
                 if(\Auth::user()->user_type_id==2){
                   $device_name=\DB::select('select id as device_id,name from devices where location_id = ?', [$location_id]);
                 }
                 else{
                         $device_name=\Auth::user()->devices()->get();
                         foreach ($device_name as $key => $value) {
                            $device_name[$key]->device_id = $value->id;
                          }
                          $location_id = 1;
                      }

             }else{

                 $selected_device_id = 1;
                 $location_id = 0;
                 $device_name=$this->deviceRepo->getAll();
                 
             }
        }else{
            
            $data_state['user_id']=\Auth::id();
            $data_state['selected_dashboard_state'] ='{"location":{"id":0,"name":"All"},"device":{"id":1,"name":"None"}}';
            $create_selected_state=$this->settingRepo->create($data_state);
            $selected_device_id = 1;
            $location_id = 0;
            $device_name=$this->deviceRepo->getAll();
        }

        if(count($setting) > 0 ){
             
              $db_update_second = $setting[0]->db_update_second * 1000;
              $interval_chart_second = $setting[0]->interval_chart_second * 1000;
              $second = $setting[0]->db_update_second;
              $chart_width = $setting[0]->chart_width;
              $chart_height = $setting[0]->chart_height;
              $minor_ticks = $setting[0]->minor_ticks;
              $red_from = intval($setting[0]->red_from);
              $red_to = intval($setting[0]->red_to);
              $yellow_from = intval($setting[0]->yellow_from);
              $yellow_to = intval($setting[0]->yellow_to);
        }else{
                
                $data['user_id'] = \Auth::id();
                $data['db_update_second'] =  10;
                $data['interval_chart_second'] = 5;
                $data['chart_width'] =  500;
                $data['chart_height'] =  150;
                $data['minor_ticks'] =  5;
                $data['red_from'] = 90;
                $data['red_to'] =  100;
                $data['yellow_from'] =  75;
                $data['yellow_to'] =  90;
                $dashboard_created_data=$this->dashboardSettingRepo->create($data);
                $db_update_second = 10 * 1000;
                $interval_chart_second = 5 * 1000;
                $second = 10;
                $chart_width = 500;
                $chart_height =150 ;
                $minor_ticks =5 ;
                $red_from =75;
                $red_to = 90;
                $yellow_from = 75;
                $yellow_to =90;
        }
        $unit=$this->settingRepo->getMeasureUnitForDashboard();
        $AllDevices=\DB::select('select id as device_id,name from devices');
        //dd($device_name);
        return view("admin.power_show",compact('auth_user','device_name','location','location_id','unit','AllDevices',
                       'selected_device_id',
                       'db_update_second',
                       'chart_width',
                       'chart_height',
                       'minor_ticks',
                       'red_from',
                       'red_to',
                       'yellow_from',
                       'yellow_to',
                       'second',
                       'interval_chart_second'
                     ));
    }

}
