<?php

namespace PowerMs\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PowerMs\Http\Requests;
use PowerMs\Http\Controllers\Controller;
use PowerMs\MyLibs\Repositories\DeviceRepository;
use PowerMs\MyLibs\Repositories\DeviceDetailRepository;
use PowerMs\MyLibs\Repositories\SettingRepository;
use PowerMs\MyLibs\Repositories\LocationRepository;

class ReportController extends Controller
{
    protected $deviceRepo;
    protected $deviceDetailRepo,$settingRepo,$locationRepo;    
    private $color_arrays=['red','green','blue',"#EF9A9A","#F44336",'#D32F2F','#42A5F5','#4DB6AC','#8E24AA','#1E88E5','#009688','#E57373','#AB47BC','#2196F3','#E53935','#9C27B0','#64B5F6','#EF5350','#BA68C8','#80CBC4','#26A69A','#90CAF9'];
    private $selected_columns=[];

    private $chart_types=['energy'=>'Energy','current'=>'Current','power'=>'Power','power_factor'=>'Power Factor','voltage'=>'Voltage','miscellaneous'=>'Miscellaneous'];
    private $selected_column_for_each_type=['energy'=>[],'current'=>[],'power'=>[],'power_factor'=>[],'voltage'=>[],'miscellaneous'=>[]];
    private $current_group=['A'=>'A','A1'=>'A1','A2'=>'A2','A3'=>'A3'];
    private $power_factor_group=['PF'=>'PF','PF1'=>'PF1','PF2'=>'PF2','PF3'=>'PF3'];
    private $voltage_group=['VLL'=>'VLL','VLN'=>'VLN','V12'=>'V12','V23'=>'V23','V31'=>'V31','V1'=>'V1','V2'=>'V2','V3'=>'V3'];
    private $power_group=['W'=>'W','W1'=>'W1','W2'=>'W2','W3'=>'W3','VAR'=>'VAR','VAR1'=>'VAR1','VAR2'=>'VAR2','VAR3'=>'VAR3','VA'=>'VA','VA1'=>'VA1','VA2'=>'VA2','VA3'=>'VA3'];
    private $energy_group=['FVAh'=>'FVAh','FWh'=>'FWh','FVARh'=>'FVARh','RVAh'=>'RVAh','RWh'=>'RWh','RVARh'=>'RVARh','onH'=>'onH','FRun'=>'FRun','RRun'=>'RRun','INTR'=>'INTR'];
    private $miscellaneour_group=['PD'=>'PD','RD'=>'RD','MaxMD'=>'MaxMD','MaxDM'=>'MaxDM'];

    function __construct(DeviceRepository $deviceRepo,DeviceDetailRepository $deviceDetailRepo,
        SettingRepository $settingRepo,LocationRepository $locationRepo)
    {
        $this->deviceRepo = $deviceRepo;
        $this->deviceDetailRepo = $deviceDetailRepo;
        $this->settingRepo=$settingRepo;
        $this->locationRepo=$locationRepo;
    }

   /* private function procressSelectedColumnForChart()
    {
        $this->selected_columns = $this->settingRepo->getReportSetting();
        // procress selected column for each chart
        foreach ($this->selected_columns as $key => $value) {
            if(array_has($this->energy_group,$value))
                $this->selected_column_for_each_type['energy'][]=$value;
            else if(array_has($this->current_group,$value))
                $this->selected_column_for_each_type['current'][]=$value;
            else if(array_has($this->power_group,$value))
                $this->selected_column_for_each_type['power'][]=$value;
            else if(array_has($this->power_factor_group,$value))
                $this->selected_column_for_each_type['power_factor'][]=$value;
            else if(array_has($this->voltage_group,$value))
                $this->selected_column_for_each_type['voltage'][]=$value;
            else if(array_has($this->miscellaneour_group,$value))
                $this->selected_column_for_each_type['miscellaneous'][]=$value;
        }   
    }

    public function electricalReportByYear(Request $request)
    {
        $this->procressSelectedColumnForChart();
        $devices=[];$is_user_selected_column=false;
        $title='Yearly electrical usage of ';
         // retrieve device list
        $dev_res=$this->deviceRepo->getAll();
        foreach ($dev_res as $d) 
        {
            $devices[$d->id]=$d->name;    
            // set title here
            if(isset($request->device_id) && $d->id==$request->device_id)
                $title.=$d->name;
        }
        
        $selected_device_id=0;
        if(isset($request->device_id))
        {
            $selected_device_id=$request->device_id;
        }else if(count($dev_res)>0)
        {
            $last_device=$dev_res[count($dev_res)-1];
            $title.=$last_device->name;
            $selected_device_id=$last_device->id;
        }
        $start_year=$end_year=date('Y');
        if(isset($request->start_year))
            $start_year=$request->start_year;
        if(isset($request->end_year))
            $end_year=$request->end_year;     
        if(count($this->selected_columns)>0)
            $is_user_selected_column=true;
        
        foreach ($this->chart_types as $key => $value) {
                $rows=[];
                $columns=$this->selected_column_for_each_type[$key];
                if(count($columns)>0){
                    $res_data=$this->deviceDetailRepo->getYearlyReport($selected_device_id,$columns,$start_year,$end_year);
                   if (count($res_data)>0) {
                        foreach ($res_data as $d)
                            $rows[]=$d;
                   }
                }
                switch ($key) {                    
                        case 'energy':
                            $energy_chart['title']='Energy :: '.$title.' ['.$start_year.'] to ['.$end_year.']';
                            $energy_chart['columns']=$columns;
                            $energy_chart['rows']=$rows;
                            break;
                        case 'current':
                            $current_chart['title']='Current :: '.$title.' ['.$start_year.'] to ['.$end_year.']';
                            $current_chart['columns']=$columns;
                            $current_chart['rows']=$rows;
                            break;
                        case 'power':
                            $power_chart['title']='Power :: '.$title.' ['.$start_year.'] to ['.$end_year.']';
                            $power_chart['columns']=$columns;
                            $power_chart['rows']=$rows;
                            break;
                        case 'power_factor':
                            $power_factor_chart['title']='Power Factor :: '.$title.' ['.$start_year.'] to ['.$end_year.']';
                            $power_factor_chart['columns']=$columns;
                            $power_factor_chart['rows']=$rows;
                            break;
                        case 'voltage':
                            $voltage_chart['title']='Voltage :: '.$title.' ['.$start_year.'] to ['.$end_year.']';
                            $voltage_chart['columns']=$columns;
                            $voltage_chart['rows']=$rows;
                            break;
                        case 'miscellaneous':
                            $miscellaneous_chart['title']='Miscellaneous :: '.$title.' ['.$start_year.'] to ['.$end_year.']';
                            $miscellaneous_chart['columns']=$columns;
                            $miscellaneous_chart['rows']=$rows;
                            break;
                    }             
            }            
        // dd($energy_chart,$power_chart,$current_chart,$voltage_chart,$power_factor_chart,$miscellaneous_chart,$this->selected_column_for_each_type);
        return view('admin.reports.by_year',[
            'is_user_selected_column'=>$is_user_selected_column,
            'energy_chart'=>$energy_chart,
            'current_chart'=>$current_chart,
            'power_chart'=>$power_chart,
            'power_factor_chart'=>$power_factor_chart,
            'voltage_chart'=>$voltage_chart,
            'miscellaneous_chart'=>$miscellaneous_chart,
            'start_year'=>$start_year,
            'end_year'=>$end_year,
            'devices'=>$devices,
            'selected_device_id'=>$selected_device_id]);
    }

    public function electricalReportByMonth(Request $request)
    {       
        $this->procressSelectedColumnForChart();
        $devices=[];$rows=[];
        $title='Monthly electrical usage of ';        
         // retrieve device list
        $dev_res=$this->deviceRepo->getAll();
        foreach ($dev_res as $d) 
        {
            $devices[$d->id]=$d->name;    
            // set title here
            if(isset($request->device_id) && $d->id==$request->device_id)  
                $title.=$d->name;
        }
        
        $selected_device_id=0;
        if(isset($request->device_id))
        {
            $selected_device_id=$request->device_id;
        }else if(count($dev_res)>0)
        {
            $last_device=$dev_res[count($dev_res)-1];
            $title.=$last_device->name;
            $selected_device_id=$last_device->id;
        }

        $year=date('Y');
        if(isset($request->date))
            $year=$request->date;

        if(count($this->selected_columns)>0)
            $is_user_selected_column=true;
        
        foreach ($this->chart_types as $key => $value) {
                $rows=[];
                $columns=$this->selected_column_for_each_type[$key];
                if(count($columns)>0){
                    $res_data=$this->deviceDetailRepo->getMonthlyReport($selected_device_id,$columns,$year);
                   if (count($res_data)>0) {
                        foreach ($res_data as $d)
                            $rows[]=$d;
                   }
                }
                switch ($key) {                    
                        case 'energy':
                            $energy_chart['title']='Energy :: '.$title.' ['.$year.']';
                            $energy_chart['columns']=$columns;
                            $energy_chart['rows']=$rows;
                            break;
                        case 'current':
                            $current_chart['title']='Current :: '.$title.' ['.$year.']';
                            $current_chart['columns']=$columns;
                            $current_chart['rows']=$rows;
                            break;
                        case 'power':
                            $power_chart['title']='Power :: '.$title.' ['.$year.']';
                            $power_chart['columns']=$columns;
                            $power_chart['rows']=$rows;
                            break;
                        case 'power_factor':
                            $power_factor_chart['title']='Power Factor :: '.$title.' ['.$year.']';
                            $power_factor_chart['columns']=$columns;
                            $power_factor_chart['rows']=$rows;
                            break;
                        case 'voltage':
                            $voltage_chart['title']='Voltage :: '.$title.' ['.$year.']';
                            $voltage_chart['columns']=$columns;
                            $voltage_chart['rows']=$rows;
                            break;
                        case 'miscellaneous':
                            $miscellaneous_chart['title']='Miscellaneous :: '.$title.' ['.$year.']';
                            $miscellaneous_chart['columns']=$columns;
                            $miscellaneous_chart['rows']=$rows;
                            break;
                    }             
            }            
        return view('admin.reports.by_month',[
            'is_user_selected_column'=>$is_user_selected_column,
            'energy_chart'=>$energy_chart,
            'current_chart'=>$current_chart,
            'power_chart'=>$power_chart,
            'power_factor_chart'=>$power_factor_chart,
            'voltage_chart'=>$voltage_chart,
            'miscellaneous_chart'=>$miscellaneous_chart,
            'year'=>$year,
            'devices'=>$devices,
            'selected_device_id'=>$selected_device_id]);
    }

    public function electricalReportByDay(Request $request)
    {        
        $this->procressSelectedColumnForChart();
        $devices=[];$is_user_selected_column=false;
        $title='Daily electrical usage of ';
         // retrieve device list
        $dev_res=$this->deviceRepo->getAll();
        foreach ($dev_res as $d) 
        {
            $devices[$d->id]=$d->name;    
            // set title here
            if(isset($request->device_id) && $d->id==$request->device_id)  
                $title.=$d->name;
        }
        
        $selected_device_id=0;
        if(isset($request->device_id))
        {
            $selected_device_id=$request->device_id;
        }else if(count($dev_res)>0)
        {
            $last_device=$dev_res[count($dev_res)-1];
            $title.=$last_device->name;
            $selected_device_id=$last_device->id;
        }

        $month=date('m');
        $year=date('Y');
        if(isset($request->date))
        {
            $res=explode("-", $request->date);
            $month=$res[0];
            $year=$res[1];
        }

        if(count($this->selected_columns)>0)
            $is_user_selected_column=true;
        
        foreach ($this->chart_types as $key => $value) {
                $rows=[];
                $columns=$this->selected_column_for_each_type[$key];
                if(count($columns)>0){
                    $res_data=$this->deviceDetailRepo->getDailyReport($selected_device_id,$columns,$month,$year);
                   if (count($res_data)>0) {
                        foreach ($res_data as $d)
                            $rows[]=$d;
                   }
                }
                switch ($key) {                    
                        case 'energy':
                            $energy_chart['title']='Energy :: '.$title.' ['.$month.'-'.$year.']';
                            $energy_chart['columns']=$columns;
                            $energy_chart['rows']=$rows;
                            break;
                        case 'current':
                            $current_chart['title']='Current :: '.$title.' ['.$month.'-'.$year.']';
                            $current_chart['columns']=$columns;
                            $current_chart['rows']=$rows;
                            break;
                        case 'power':
                            $power_chart['title']='Power :: '.$title.' ['.$month.'-'.$year.']';
                            $power_chart['columns']=$columns;
                            $power_chart['rows']=$rows;
                            break;
                        case 'power_factor':
                            $power_factor_chart['title']='Power Factor :: '.$title.' ['.$month.'-'.$year.']';
                            $power_factor_chart['columns']=$columns;
                            $power_factor_chart['rows']=$rows;
                            break;
                        case 'voltage':
                            $voltage_chart['title']='Voltage :: '.$title.' ['.$month.'-'.$year.']';
                            $voltage_chart['columns']=$columns;
                            $voltage_chart['rows']=$rows;
                            break;
                        case 'miscellaneous':
                            $miscellaneous_chart['title']='Miscellaneous :: '.$title.' ['.$month.'-'.$year.']';
                            $miscellaneous_chart['columns']=$columns;
                            $miscellaneous_chart['rows']=$rows;
                            break;
                    }             
            }            
        return view('admin.reports.by_day',[
            'is_user_selected_column'=>$is_user_selected_column,
            'energy_chart'=>$energy_chart,
            'current_chart'=>$current_chart,
            'power_chart'=>$power_chart,
            'power_factor_chart'=>$power_factor_chart,
            'voltage_chart'=>$voltage_chart,
            'miscellaneous_chart'=>$miscellaneous_chart,
            'month'=>$month,
            'year'=>$year,
            'devices'=>$devices,
            'selected_device_id'=>$selected_device_id]);
    }
    
    public function electricalReportByHour(Request $request)
    {
        $this->procressSelectedColumnForChart();
        $devices=[];$is_user_selected_column=false;
        $title='Hourly electrical usage of ';
         // retrieve device list
        $dev_res=$this->deviceRepo->getAll();
        foreach ($dev_res as $d) 
        {
            $devices[$d->id]=$d->name;    
            // set title here
            if(isset($request->device_id) && $d->id==$request->device_id)  
                $title.=$d->name;
        }
        
        $selected_device_id=0;
        if(isset($request->device_id))
        {
            $selected_device_id=$request->device_id;
        }else if(count($dev_res)>0)
        {
            $last_device=$dev_res[count($dev_res)-1];
            $title.=$last_device->name;
            $selected_device_id=$last_device->id;
        }

        $date=date('d-m-Y');
        if(isset($request->date))
            $date=$request->date;
        
        if(count($this->selected_columns)>0)
            $is_user_selected_column=true;
        
        foreach ($this->chart_types as $key => $value) {
                $rows=[];
                $columns=$this->selected_column_for_each_type[$key];
                if(count($columns)>0){
                    $res_data=$this->deviceDetailRepo->getHourlyReport($selected_device_id,$columns,$date);
                   if (count($res_data)>0) {
                        foreach ($res_data as $d)
                            $rows[]=$d;
                   }
                }
                switch ($key) {                    
                        case 'energy':
                            $energy_chart['title']='Energy :: '.$title.' ['.$date.']';
                            $energy_chart['columns']=$columns;
                            $energy_chart['rows']=$rows;
                            break;
                        case 'current':
                            $current_chart['title']='Current :: '.$title.' ['.$date.']';
                            $current_chart['columns']=$columns;
                            $current_chart['rows']=$rows;
                            break;
                        case 'power':
                            $power_chart['title']='Power :: '.$title.' ['.$date.']';
                            $power_chart['columns']=$columns;
                            $power_chart['rows']=$rows;
                            break;
                        case 'power_factor':
                            $power_factor_chart['title']='Power Factor :: '.$title.' ['.$date.']';
                            $power_factor_chart['columns']=$columns;
                            $power_factor_chart['rows']=$rows;
                            break;
                        case 'voltage':
                            $voltage_chart['title']='Voltage :: '.$title.' ['.$date.']';
                            $voltage_chart['columns']=$columns;
                            $voltage_chart['rows']=$rows;
                            break;
                        case 'miscellaneous':
                            $miscellaneous_chart['title']='Miscellaneous :: '.$title.' ['.$date.']';
                            $miscellaneous_chart['columns']=$columns;
                            $miscellaneous_chart['rows']=$rows;
                            break;
                    }             
            }            
        return view('admin.reports.by_hour',[
            'is_user_selected_column'=>$is_user_selected_column,
            'energy_chart'=>$energy_chart,
            'current_chart'=>$current_chart,
            'power_chart'=>$power_chart,
            'power_factor_chart'=>$power_factor_chart,
            'voltage_chart'=>$voltage_chart,
            'miscellaneous_chart'=>$miscellaneous_chart,
            'date'=>$date,
            'devices'=>$devices,
            'selected_device_id'=>$selected_device_id]);

    }
    
    public function electricalReportByTime(Request $request)
    {
        $this->procressSelectedColumnForChart();
        $is_user_selected_column=false;
        $energy_chart=$power_chart=$current_chart=$voltage_chart=$power_factor_chart=$miscellaneous_chart=[];
        $devices=[];
        $title='Timely electrical usage of ';
         // retrieve device list
        $dev_res=$this->deviceRepo->getAll();
        foreach ($dev_res as $d) 
        {
            $devices[$d->id]=$d->name;    
            // set title here
            if(isset($request->device_id) && $d->id==$request->device_id)  
                $title.=$d->name;
        }
        
        $selected_device_id=0;
        if(isset($request->device_id))
        {
            $selected_device_id=$request->device_id;
        }else if(count($dev_res)>0)
        {
            $last_device=$dev_res[count($dev_res)-1];
            $title.=$last_device->name;
            $selected_device_id=$last_device->id;
        }

        $start_time=$end_time=date('d-m-Y h:i A');
        if(isset($request->start_time))
            $start_time=$request->start_time;
        if(isset($request->end_time))
            $end_time=$request->end_time;        

        if(count($this->selected_columns)>0)
            $is_user_selected_column=true;
            foreach ($this->chart_types as $key => $value) {
                $rows=[];
                $columns=$this->selected_column_for_each_type[$key];
                if(count($columns)>0){
                    $res_data=$this->deviceDetailRepo->getTimelyReport($selected_device_id,$columns,$start_time,$end_time);
                   if (count($res_data)>0) {
                        foreach ($res_data as $d)
                            $rows[]=$d;
                   }
                }
                switch ($key) {                    
                        case 'energy':
                            $energy_chart['title']='Energy :: '.$title.' ['.$start_time.'] to ['.$end_time.']';
                            $energy_chart['columns']=$columns;
                            $energy_chart['rows']=$rows;
                            break;
                        case 'current':
                            $current_chart['title']='Current :: '.$title.' ['.$start_time.'] to ['.$end_time.']';
                            $current_chart['columns']=$columns;
                            $current_chart['rows']=$rows;
                            break;
                        case 'power':
                            $power_chart['title']='Power :: '.$title.' ['.$start_time.'] to ['.$end_time.']';
                            $power_chart['columns']=$columns;
                            $power_chart['rows']=$rows;
                            break;
                        case 'power_factor':
                            $power_factor_chart['title']='Power Factor :: '.$title.' ['.$start_time.'] to ['.$end_time.']';
                            $power_factor_chart['columns']=$columns;
                            $power_factor_chart['rows']=$rows;
                            break;
                        case 'voltage':
                            $voltage_chart['title']='Voltage :: '.$title.' ['.$start_time.'] to ['.$end_time.']';
                            $voltage_chart['columns']=$columns;
                            $voltage_chart['rows']=$rows;
                            break;
                        case 'miscellaneous':
                            $miscellaneous_chart['title']='Miscellaneous :: '.$title.' ['.$start_time.'] to ['.$end_time.']';
                            $miscellaneous_chart['columns']=$columns;
                            $miscellaneous_chart['rows']=$rows;
                            break;
                    }             
            }            
        
        // dd($energy_chart,$power_chart,$current_chart,$voltage_chart,$power_factor_chart,$miscellaneous_chart,$this->selected_column_for_each_type);
        $s_time=date_create_from_format('d-m-Y h:i A',$start_time);
        $e_time=date_create_from_format('d-m-Y h:i A',$end_time);
        if($s_time>$e_time)
        {
            toast()->error('Start time must less than end time.');
            return view('admin.reports.by_time',[
                'date_has_error'=>true,
                'start_time'=>$start_time,
                'end_time'=>$end_time,
                'devices'=>$devices,
                'selected_device_id'=>$selected_device_id]);
        }
        return view('admin.reports.by_time',[
            'date_has_error'=>false,
            'is_user_selected_column'=>$is_user_selected_column,
            'energy_chart'=>$energy_chart,
            'current_chart'=>$current_chart,
            'power_chart'=>$power_chart,
            'power_factor_chart'=>$power_factor_chart,
            'voltage_chart'=>$voltage_chart,
            'miscellaneous_chart'=>$miscellaneous_chart,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'devices'=>$devices,
            'selected_device_id'=>$selected_device_id]);
    }*/
    
    public function showDailyWReport(Request $request,$group_by)
    {
        $devices=[];$setting_id=0;
        $selected_location=null;$selected_device=null;
        $selected_device_id=0;
        $locations[0]=(object)['id'=>0,'name'=>'All'];
        $measureUnit=$this->settingRepo->getMeasureUnitForW();
        // retrieve location list
        {
            $res=$this->locationRepo->getAll();
            foreach ($res as $value) 
                $locations[]=(object)['id'=>$value->id,'name'=>$value->location_name];
        }
        $title='Electrical usage ('.$measureUnit.') of ';        
        
        //get setting obj
        {
            $w_setting=null;
            $dashboard_setting=null;
            $res=$this->settingRepo->getByUserId(\Auth::user()->id);
            if(count($res)>0){
                $w_setting=json_decode($res[0]->selected_state_w_report);
                $dashboard_setting=json_decode($res[0]->selected_dashboard_state); // location & device state need to be from dashboard value
                $setting_id=$res[0]->id;
            }
        }
        //set selected_location
        if (isset($request->location_id))// this is come from search button, so set selected_location with user's selected location_id
        {
            if($request->location_id==0){// use select 'All'
                $selected_location=$locations[0];
            }else{
                $selected_location=array_first($locations,function($key,$value) use($request){
                    return $value->id==$request->location_id;
                });    
            }            
        }else{
            if(!is_null($dashboard_setting)){// get selected location from setting, else set last object from array
                $selected_location=$dashboard_setting->location;                
            }else if(count($selected_location)>0)
                $selected_location=$locations[count($locations)-1];            
        }

         // retrieve device list        
        {
            if(\Auth::user()->user_type_id==2){//admin
                if(is_null($selected_location))
                    $dev_res=$this->deviceRepo->getAll();
                else if($selected_location->id==0)
                    $dev_res=$this->deviceRepo->getAll();
                else//get by location Id
                    $dev_res=$this->deviceRepo->getDevicesByLocation($selected_location->id);
            }else
                $dev_res=\Auth::user()->devices()->get();
            foreach ($dev_res as $d) 
                $devices[]=(object)['id'=>$d->id,'name'=>$d->name];
        }

        //set selected_device
        if (isset($request->device_id))// this is come from search button, so set selected_device with user's selected device_id
        {
            $selected_device=array_first($devices,function($key,$value) use($request){                
                return $value->id==$request->device_id;
            }); 
        }else{
            if(!is_null($dashboard_setting))// get selected device from setting, else set last object from array
                $selected_device=$dashboard_setting->device;
            else if(count($devices)>0)
                $selected_device=$devices[count($devices)-1];
        }       
        // dd($devices,$selected_device,$w_setting);
        if (isset($request->date))// this is come from search button, so set selected_device with user's date
        {
            $date=$request->date;    
        }else{
            if(!is_null($w_setting))// get selected date from setting, else set today date
                $date=$w_setting->date;
            else
                $date=date('d-m-Y');
        }        

        //update setting
        $w_setting=(object)['location'=>$selected_location,'device'=>$selected_device,'date'=>$date];
        if($setting_id>0)
            $this->settingRepo->update(['selected_state_w_report'=>json_encode($w_setting)],$setting_id);
        else{
            $data['user_id']=\Auth::user()->id;
            $data['selected_state_w_report']=json_encode($w_setting);
            $this->settingRepo->create($data);
        }
        // dd($devices,$selected_device);
        // concat device name at title
        if(!is_null($selected_device))
            $title.=$selected_device->name;

        if($group_by=='hour'){
                $x_title='Hours';
                $grid_count=24;
                $time_format='hh a';
        }
        else if($group_by=='30mins'){
            $x_title='Minutes';
            $grid_count=48;
            $time_format='hh:mm a';
        }
        else if($group_by=='15mins'){
            $x_title='Minutes';
            $grid_count=96;
            $time_format='hh:mm a';
        }
        // dd($request->all());

        $y_title=$measureUnit;
        $chart_data=null;
        $min=0;$max=0;$avg=0;$total=0;

        if(!is_null($selected_device)){
            $res=$this->deviceDetailRepo->getDaily_W_Report($selected_device->id,$date,$group_by,$measureUnit);        
            
            if(count($res)>0){
                $chart_data="[[{type: 'datetime', label: 'Date'}, {type: 'number', label: '".$measureUnit."'}]";
                $min=$res[0]->W;
                for ($i=0; $i < count($res) ; $i++) {
                    // $chart_data[$i]['date']='new Date('.$res[$i]->year.','.$res[$i]->month.','.$res[$i]->day.','.$res[$i]->hour.','.$res[$i]->minute.')';
                    // $chart_data[$i]['W']= $res[$i]->W;
                    $chart_data.=',["Date('.$res[$i]->year.','.($res[$i]->month-1).','.$res[$i]->day.','.$res[$i]->hour.','.$res[$i]->minute.','.$res[$i]->second.')",'.$res[$i]->W.']';
                    // if($res[$i]->W < $min)
                    //     $min=$res[$i]->W;
                    // if($res[$i]->W > $max)
                    //     $max=$res[$i]->W;
                    $total+=$res[$i]->W;
                }
                $chart_data.="]";
                $avg=$total/count($res);
            }
            $res=$this->deviceDetailRepo->getMinMaxValueFor_W_Report($selected_device->id,$date,$measureUnit);
            $min=$res[0]->min_value;
            $max=$res[0]->max_value;
        }
        
        // dd($selected_location,$locations,$selected_device,$devices,$date,$group_by,$measureUnit);        
        return view('admin.reports.daily_w_report',[
            'date'=>$date,
            'devices'=>$devices,
            'chart_data'=>$chart_data,
            'group_by'=>$group_by,
            'title'=>$title,
            'x_title'=>$x_title,
            'y_title'=>$y_title,
            'time_format'=>$time_format,
            'grid_count'=>$grid_count,
            'min'=>$this->autoConvertUnit($min),
            'max'=>$this->autoConvertUnit($max),
            'avg'=>$this->autoConvertUnit($avg),
            'measure_unit'=>$measureUnit,
            'locations'=>$locations,
            'selected_location'=>$selected_location,
            'selected_device'=>$selected_device]);
    }

    public function showWhReportByDateRange(Request $request)
    { 
        $setting_id=0;$devices=[];
        $selected_location=null;$selected_device=null;        
        $locations[0]=(object)['id'=>0,'name'=>'All'];

        $measureUnit=$this->settingRepo->getMeasureUnitForWh();        
        $title='Daily electrical usage ('.$measureUnit.'h) of ';
        // retrieve location list
        {
            $res=$this->locationRepo->getAll();
            foreach ($res as $value) 
                $locations[]=(object)['id'=>$value->id,'name'=>$value->location_name];
        }            
        //get setting obj
        {
            $wh_setting=null;$dashboard_setting=null;
            $res=$this->settingRepo->getByUserId(\Auth::user()->id);
            if(count($res)>0){
                $wh_setting=json_decode($res[0]->selected_state_wh_report_by_date_range);                       
                $dashboard_setting=json_decode($res[0]->selected_dashboard_state); // location & device state need to be from dashboard value
                $setting_id=$res[0]->id;
            }
        }
        //set selected_location
        if (isset($request->location_id))// this is come from search button, so set selected_location with user's selected location_id
        {
            if($request->location_id==0){// use select 'All'
                $selected_location=$locations[0];
            }else{
                $selected_location=array_first($locations,function($key,$value) use($request){
                    return $value->id==$request->location_id;
                });    
            }      
        }else{
            if(!is_null($dashboard_setting))// get selected location from setting, else set last object from array
                $selected_location=$dashboard_setting->location;
            else if(count($selected_location)>0)
                $selected_location=$locations[count($locations)-1];            
        }

         // retrieve device list        
        {
            if(\Auth::user()->user_type_id==2){//admin
                if(is_null($selected_location))
                    $dev_res=$this->deviceRepo->getAll();
                else if($selected_location->id==0)
                    $dev_res=$this->deviceRepo->getAll();
                else//get by location Id
                    $dev_res=$this->deviceRepo->getDevicesByLocation($selected_location->id);
            }else
                $dev_res=\Auth::user()->devices()->get();
            foreach ($dev_res as $d) 
                $devices[]=(object)['id'=>$d->id,'name'=>$d->name];
        }

        //set selected_device
        if (isset($request->device_id))// this is come from search button, so set selected_device with user's selected device_id
        {
            $selected_device=array_first($devices,function($key,$value) use($request){                
                return $value->id==$request->device_id;
            }); 
        }else{
            if(!is_null($dashboard_setting))// get selected device from setting, else set last object from array
                $selected_device=$dashboard_setting->device;
            else
                $selected_device=$devices[count($devices)-1];
        }       
        // dd($devices,$selected_device,$wh_setting);
        if (isset($request->start_date))// this is come from search button, so set selected_device with user's date
        {
            $start_date=$request->start_date;    
            $end_date=$request->end_date;
        }else{
            if(!is_null($wh_setting)){// get selected date from setting, else set today date
                $start_date=$wh_setting->start_date;
                $end_date=$wh_setting->end_date;
            }
            else
                $start_date=$end_date=date('d-m-Y');
        }

        //update setting
        $wh_setting=(object)['location'=>$selected_location,'device'=>$selected_device,'start_date'=>$start_date,'end_date'=>$end_date];
        if($setting_id>0)
            $this->settingRepo->update(['selected_state_wh_report_by_date_range'=>json_encode($wh_setting)],$setting_id);
        else{
            $data['user_id']=\Auth::user()->id;
            $data['selected_state_wh_report_by_date_range']=json_encode($wh_setting);
            $this->settingRepo->create($data);
        }

        $chart_data=null;
        //diff amount from date1-date2 to get actual usage value
        $min=0;$max=0;$avg=0;$total=0;
        if(!is_null($selected_device)){
            $title.=$selected_device->name;  
            $res=$this->deviceDetailRepo->getDailyReportForFwh($selected_device->id,$start_date,$end_date,$measureUnit);
           
            if(count($res)>0)
                $min=$res[0]->FWh;
            $index=0;$temp=0;
            $today_FWh=0;$yesterday_FWh=0;  
            $no_of_columns=0;      
            for ($i=1; $i < count($res) ; $i++) {
                $chart_data[$index]['date']=$res[$i]->day;

                $today_FWh=$res[$i]->FWh > 0 ? $res[$i]->FWh : $today_FWh;            
                $yesterday_FWh=$res[$i-1]->FWh > 0 ? $res[$i-1]->FWh : $yesterday_FWh;
                // echo $i."=> today_FWh=".$today_FWh.",yesterday_FWh=".$yesterday_FWh.'(before check)<br/>';
                if($today_FWh<=0)
                    $today_FWh=$yesterday_FWh;
                // echo $i."=> today_FWh=".$today_FWh.",yesterday_FWh=".$yesterday_FWh.'(after check)<br/>';

                $diff_value= $today_FWh - $yesterday_FWh;
                // echo $i."=> diff_value=".$diff_value."<br/>";
                $chart_data[$index][$measureUnit]= $temp =$diff_value>0 ? $diff_value : $temp;            
                if($temp<$min)
                    $min=$temp;
                if($temp>$max)
                    $max=$temp;
                $total+=$temp;
                $index++;
                $no_of_columns++;
            }
            if(count($res)>0)
                $avg=$total/$no_of_columns;
        }else
            $chart_data=null;
        // $title.=" (Wh)";
        $y_title=$measureUnit.'h';
        $s_date=date_create_from_format('d-m-Y',$start_date);
        $e_date=date_create_from_format('d-m-Y',$end_date);
        // dd($chart_data);
        if($s_date>$e_date)
        {
            toast()->error('Start date must less than end date.');
            return view('admin.reports.wh_report_by_date_range',[
                'date_has_error'=>true,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'devices'=>$devices,
                'title'=>$title,
                'y_title'=>$y_title,
                'measure_unit'=>$measureUnit.'h',
                'min_value'=>$this->autoConvertUnit($min),'max_value'=>$this->autoConvertUnit($max),
                'avg'=>$this->autoConvertUnit($avg),'total_value'=>$this->autoConvertUnit($total),
                'locations'=>$locations,
                'selected_location'=>$selected_location,
                'selected_device'=>$selected_device]);
        }      
        
        return view('admin.reports.wh_report_by_date_range',[
            'date_has_error'=>false,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'devices'=>$devices,
            'chart_data'=>$chart_data,
            'title'=>$title,
            'y_title'=>$y_title,            
            'min_value'=>$this->autoConvertUnit($min),'max_value'=>$this->autoConvertUnit($max),
            'avg'=>$this->autoConvertUnit($avg),'total_value'=>$this->autoConvertUnit($total),
            'locations'=>$locations,
            'selected_location'=>$selected_location,
            'selected_device'=>$selected_device]);
    }

    public function showWhReportByHour(Request $request)
    {
        $setting_id=0;$devices=[];
        $selected_location=null;$selected_device=null;        
        $locations[0]=(object)['id'=>0,'name'=>'All'];

        $measureUnit=$this->settingRepo->getMeasureUnitForWh();        
        $title='Hourly electrical usage ('.$measureUnit.'h) of ';
        // retrieve location list
        {
            $res=$this->locationRepo->getAll();
            foreach ($res as $value) 
                $locations[]=(object)['id'=>$value->id,'name'=>$value->location_name];
        }
         
        //get setting obj
        {
            $wh_setting=null;$dashboard_setting=null;
            $res=$this->settingRepo->getByUserId(\Auth::user()->id);
            if(count($res)>0){
                $wh_setting=json_decode($res[0]->selected_state_wh_report_by_hour);                            
                $dashboard_setting=json_decode($res[0]->selected_dashboard_state); // location & device state need to be from dashboard value
                $setting_id=$res[0]->id;
            }
        }
        //set selected_location
        if (isset($request->location_id))// this is come from search button, so set selected_location with user's selected location_id
        {
            if($request->location_id==0){// use select 'All'
                $selected_location=$locations[0];
            }else{
                $selected_location=array_first($locations,function($key,$value) use($request){
                    return $value->id==$request->location_id;
                });    
            }       
        }else{
            if(!is_null($dashboard_setting))// get selected location from setting, else set last object from array
                $selected_location=$dashboard_setting->location;
            else
                $selected_location=$locations[count($locations)-1];            
        }
        // retrieve device list        
        {
            if(\Auth::user()->user_type_id==2){//admin
                if(is_null($selected_location))
                    $dev_res=$this->deviceRepo->getAll();
                else if($selected_location->id==0)
                    $dev_res=$this->deviceRepo->getAll();
                else//get by location Id
                    $dev_res=$this->deviceRepo->getDevicesByLocation($selected_location->id);
            }else
                $dev_res=\Auth::user()->devices()->get();
            foreach ($dev_res as $d) 
                $devices[]=(object)['id'=>$d->id,'name'=>$d->name];
        }
        //set selected_device
        if (isset($request->device_id))// this is come from search button, so set selected_device with user's selected device_id
        {
            $selected_device=array_first($devices,function($key,$value) use($request){                
                return $value->id==$request->device_id;
            }); 
        }else{
            if(!is_null($dashboard_setting))// get selected device from setting, else set last object from array
                $selected_device=$dashboard_setting->device;
            else if(count($devices)>0)
                $selected_device=$devices[count($devices)-1];
        }       
        // dd($devices,$selected_device,$wh_setting);
        if (isset($request->date))// this is come from search button, so set selected_device with user's date
        {
            $date=$request->date;    
        }else{
            if(!is_null($wh_setting))// get selected date from setting, else set today date
                $date=$wh_setting->date;
            else
                $date=date('d-m-Y');
        }

        //update setting
        $wh_setting=(object)['location'=>$selected_location,'device'=>$selected_device,'date'=>$date];
        if($setting_id>0)
            $this->settingRepo->update(['selected_state_wh_report_by_hour'=>json_encode($wh_setting)],$setting_id);
        else{
            $data['user_id']=\Auth::user()->id;
            $data['selected_state_wh_report_by_hour']=json_encode($wh_setting);
            $this->settingRepo->create($data);
        }

        $chart_data="[['Hours', '".$measureUnit."h']";
        $y_title=$measureUnit.'h';
        $min_value=0;$max_value=0;$total_value=0;$avg=0;
        if(!is_null($selected_device)){
            $title.=$selected_device->name;         
            // dd($selected_device);
            $res=$this->deviceDetailRepo->get_Wh_ReportByHour($selected_device->id,$date,$measureUnit);            
          if(count($res)>1)
          {
            $min_value=$res[0]->FWh;        
            $no_of_columns=0;
             //diff amount from date1-date2 to get actual usage value
            $temp=0;
            $today_FWh=0;$yesterday_FWh=0;
            for ($i=1; $i < count($res) ; $i++) {            

                $today_FWh=$res[$i]->FWh > 0 ? $res[$i]->FWh : $today_FWh;            
                $yesterday_FWh=$res[$i-1]->FWh > 0 ? $res[$i-1]->FWh : $yesterday_FWh;            
                if($today_FWh<=0)
                    $today_FWh=$yesterday_FWh;

                $diff_value= $today_FWh - $yesterday_FWh;
                $Wh_value=$temp=$diff_value>0 ? $diff_value : $temp;             
                $chart_data.=",['".$res[$i]->hour."',".round($Wh_value,2)."]";        
                $total_value+=$Wh_value;
                $min_value=($Wh_value<$min_value)?$Wh_value:$min_value;
                $max_value=($Wh_value>$max_value)?$Wh_value:$max_value;
                $no_of_columns++;
            }
            $chart_data.="]";        
            if($no_of_columns<=1)
                $avg=round($total_value,2); 
            else
                $avg=round($total_value/$no_of_columns,2);  
            // $total_value=round($res[count($res)-1]->FWh,2);// last record value
          }else
            $chart_data=null;            
        }else
            $chart_data=null;
        
        // dd($res,$chart_data,$no_of_columns);
        return view('admin.reports.wh_report_by_hour',[
            'date'=>$date,
            'devices'=>$devices,
            'chart_data'=>$chart_data,
            'title'=>$title,
            'y_title'=>$y_title,
            'measure_unit'=>$measureUnit.'h',
            'min_value'=>$this->autoConvertUnit($min_value),
            'max_value'=>$this->autoConvertUnit($max_value),
            'avg'=>$this->autoConvertUnit($avg),
            'total_value'=>$this->autoConvertUnit($total_value),
            'locations'=>$locations,
            'selected_location'=>$selected_location,
            'selected_device'=>$selected_device]);
    }

    public function showWhReportByDay(Request $request)
    {
        $setting_id=0;$devices=[];
        $selected_location=null;$selected_device=null;        
        $locations[0]=(object)['id'=>0,'name'=>'All'];

        $measureUnit=$this->settingRepo->getMeasureUnitForWh();        
        $title='Daily electrical usage ('.$measureUnit.'h) of ';
        // retrieve location list
        {
            $res=$this->locationRepo->getAll();
            foreach ($res as $value) 
                $locations[]=(object)['id'=>$value->id,'name'=>$value->location_name];
        }         
        //get setting obj
        {
            $w_setting=null;
            $res=$this->settingRepo->getByUserId(\Auth::user()->id);
            if(count($res)>0){
                $w_setting=json_decode($res[0]->selected_state_wh_report_by_day);  
                $dashboard_setting=json_decode($res[0]->selected_dashboard_state); // location & device state need to be from dashboard value
                $setting_id=$res[0]->id;
            }
        }
        //set selected_location
        if (isset($request->location_id))// this is come from search button, so set selected_location with user's selected location_id
        {
           if($request->location_id==0){// use select 'All'
                $selected_location=$locations[0];
            }else{
                $selected_location=array_first($locations,function($key,$value) use($request){
                    return $value->id==$request->location_id;
                });    
            }     
        }else{
            if(!is_null($dashboard_setting))// get selected location from setting, else set last object from array
                $selected_location=$dashboard_setting->location;
            else if(count($locations)>0)
                $selected_location=$locations[count($locations)-1];            
        }

         // retrieve device list        
        {
            if(\Auth::user()->user_type_id==2){//admin
                if(is_null($selected_location))
                    $dev_res=$this->deviceRepo->getAll();
                else if($selected_location->id==0)
                    $dev_res=$this->deviceRepo->getAll();
                else//get by location Id
                    $dev_res=$this->deviceRepo->getDevicesByLocation($selected_location->id);
            }else
                $dev_res=\Auth::user()->devices()->get();
            foreach ($dev_res as $d) 
                $devices[]=(object)['id'=>$d->id,'name'=>$d->name];
        }

        //set selected_device
        if (isset($request->device_id))// this is come from search button, so set selected_device with user's selected device_id
        {
            $selected_device=array_first($devices,function($key,$value) use($request){                
                return $value->id==$request->device_id;
            }); 
        }else{
            if(!is_null($dashboard_setting))// get selected device from setting, else set last object from array
                $selected_device=$dashboard_setting->device;
            else
                $selected_device=$devices[count($devices)-1];
        }       
        // dd($devices,$selected_device,$w_setting);
        if (isset($request->month_year))// this is come from search button, so set selected_device with user's date
        {
            $month_year=$request->month_year;    
        }else{
            if(!is_null($w_setting))// get selected date from setting, else set today date
                $month_year=$w_setting->month_year;
            else
                $month_year=date('m-Y');
        }

        //update setting
        $w_setting=(object)['location'=>$selected_location,'device'=>$selected_device,'month_year'=>$month_year];
        if($setting_id>0)
            $this->settingRepo->update(['selected_state_wh_report_by_day'=>json_encode($w_setting)],$setting_id);
        else{
            $data['user_id']=\Auth::user()->id;
            $data['selected_state_wh_report_by_day']=json_encode($w_setting);
            $this->settingRepo->create($data);
        }

        $chart_data="[['Date', '".$measureUnit."h']";
        $min_value=0;$max_value=0;$avg=0;$total_value=0;
        $no_of_columns=0;
        $y_title=$measureUnit.'h';

        if(!is_null($selected_device)){
            $title.=$selected_device->name;
            $res=$this->deviceDetailRepo->get_Wh_ReportByDay($selected_device->id,$month_year,$measureUnit);
              if(count($res)>1)
              { 
                $min_value=$res[0]->FWh;
                 //diff amount from date1-date2 to get actual usage value
                $temp=0;
                $today_FWh=0;$yesterday_FWh=0;
                for ($i=1; $i < count($res) ; $i++) {            

                    $today_FWh=$res[$i]->FWh > 0 ? $res[$i]->FWh : $today_FWh;            
                    $yesterday_FWh=$res[$i-1]->FWh > 0 ? $res[$i-1]->FWh : $yesterday_FWh;            
                    if($today_FWh<=0)
                        $today_FWh=$yesterday_FWh;

                    $diff_value= $today_FWh - $yesterday_FWh;
                    $Wh_value=$temp=$diff_value>0 ? $diff_value : $temp;             
                    $chart_data.=",['".$res[$i]->day."',".round($Wh_value,2)."]";        
                    $total_value+=$Wh_value;
                    $min_value=($Wh_value<$min_value)?$Wh_value:$min_value;
                    $max_value=($Wh_value>$max_value)?$Wh_value:$max_value;
                    $no_of_columns++;
                }
                $chart_data.="]";
                if($no_of_columns<=1)
                    $avg=round($total_value,2);              
                else
                    $avg=round($total_value/($no_of_columns),2);  
              }else
                $chart_data=null;
        }else
            $chart_data=null;
        // dd($res,$devices,$locations,$selected_device,$no_of_columns,$chart_data);
        return view('admin.reports.wh_report_by_day',[
            'month_year'=>$month_year,
            'devices'=>$devices,
            'chart_data'=>$chart_data,
            'title'=>$title,
            'y_title'=>$y_title,            
            'min_value'=>$this->autoConvertUnit($min_value),
            'max_value'=>$this->autoConvertUnit($max_value),
            'avg'=>$this->autoConvertUnit($avg),
            'total_value'=>$this->autoConvertUnit($total_value),
            'locations'=>$locations,
            'selected_location'=>$selected_location,
            'selected_device'=>$selected_device]);
    }

    public function showWhReportByMonth(Request $request)
    {
        $setting_id=0;$devices=[];
        $selected_location=null;$selected_device=null;        
        $locations[0]=(object)['id'=>0,'name'=>'All'];

        $measureUnit=$this->settingRepo->getMeasureUnitForWh();        
        $title='Monthly electrical usage ('.$measureUnit.'h) of ';
        // retrieve location list
        {
            $res=$this->locationRepo->getAll();
            foreach ($res as $value) 
                $locations[]=(object)['id'=>$value->id,'name'=>$value->location_name];
        }         
        //get setting obj
        {
            $w_setting=null;$dashboard_setting=null;
            $res=$this->settingRepo->getByUserId(\Auth::user()->id);
            if(count($res)>0){
                $w_setting=json_decode($res[0]->selected_state_wh_report_by_month);  
                $dashboard_setting=json_decode($res[0]->selected_dashboard_state); // location & device state need to be from dashboard value
                $setting_id=$res[0]->id;
            }
        }
        //set selected_location
        if (isset($request->location_id))// this is come from search button, so set selected_location with user's selected location_id
        {
            if($request->location_id==0){// use select 'All'
                $selected_location=$locations[0];
            }else{
                $selected_location=array_first($locations,function($key,$value) use($request){
                    return $value->id==$request->location_id;
                });    
            }  
        }else{
            if(!is_null($dashboard_setting))// get selected location from setting, else set last object from array
                $selected_location=$dashboard_setting->location;
            else if(count($selected_location)>0)
                $selected_location=$locations[count($locations)-1];            
        }

         // retrieve device list        
        {
            if(\Auth::user()->user_type_id==2){//admin
                if(is_null($selected_location))
                    $dev_res=$this->deviceRepo->getAll();
                else if($selected_location->id==0)
                    $dev_res=$this->deviceRepo->getAll();
                else//get by location Id
                    $dev_res=$this->deviceRepo->getDevicesByLocation($selected_location->id);
            }else
                $dev_res=\Auth::user()->devices()->get();
            foreach ($dev_res as $d) 
                $devices[]=(object)['id'=>$d->id,'name'=>$d->name];
        }

        //set selected_device
        if (isset($request->device_id))// this is come from search button, so set selected_device with user's selected device_id
        {
            $selected_device=array_first($devices,function($key,$value) use($request){                
                return $value->id==$request->device_id;
            }); 
        }else{
            if(!is_null($dashboard_setting))// get selected device from setting, else set last object from array
                $selected_device=$dashboard_setting->device;
            else
                $selected_device=$devices[count($devices)-1];
        }       
        // dd($devices,$selected_device,$w_setting);
        if (isset($request->year))// this is come from search button, so set selected_device with user's date
        {
            $year=$request->year;    
        }else{
            if(!is_null($w_setting))// get selected date from setting, else set today date
                $year=$w_setting->year;
            else
                $year=date('Y');
        }

        //update setting
        $w_setting=(object)['location'=>$selected_location,'device'=>$selected_device,'year'=>$year];
        if($setting_id>0)
            $this->settingRepo->update(['selected_state_wh_report_by_month'=>json_encode($w_setting)],$setting_id);
        else{
            $data['user_id']=\Auth::user()->id;
            $data['selected_state_wh_report_by_month']=json_encode($w_setting);
            $this->settingRepo->create($data);
        }

        $chart_data="[['Months', '".$measureUnit."h']";
        $min_value=0;$max_value=0;$total_value=0;$avg=0;
        $no_of_columns=0;
        $y_title=$measureUnit.'h';

        if(!is_null($selected_device)){
            $title.=$selected_device->name;
            $res=$this->deviceDetailRepo->get_Wh_ReportByMonth($selected_device->id,$year,$measureUnit);
            if(count($res)==0)
                $chart_data=null;
            if(count($res)==13)
            {
                $min_value=$res[0]->FWh;
             //diff amount from month1-month2 to get actual usage value
                $temp=0;$current_month_FWh=0;$previous_month_FWh=0;
                for ($i=1; $i < count($res) ; $i++) {            
                    $current_month_FWh=$res[$i]->FWh > 0 ? $res[$i]->FWh : $current_month_FWh;            
                    $previous_month_FWh=$res[$i-1]->FWh > 0 ? $res[$i-1]->FWh : $previous_month_FWh;            
                    if($current_month_FWh<=0)
                        $current_month_FWh=$previous_month_FWh;

                    $diff_value= $current_month_FWh - $previous_month_FWh;
                    $Wh_value=$temp=$diff_value>0 ? $diff_value : $temp;                 
                    $chart_data.=",['".$res[$i]->month."',".round($Wh_value,2)."]";        
                    $total_value+=$Wh_value;
                    $min_value=($Wh_value<$min_value)?$Wh_value:$min_value;
                    $max_value=($Wh_value>$max_value)?$Wh_value:$max_value;
                    $no_of_columns++;
                }
                $chart_data.="]";            
            }else if(count($res)>0 && count($res)<=12){// start from zero value 
                $min_value=$res[0]->FWh;
                $temp=0;$current_month_FWh=0;$previous_month_FWh=0;
                for ($i=0; $i < count($res) ; $i++) {

                    $current_month_FWh=$res[$i]->FWh > 0 ? $res[$i]->FWh : $current_month_FWh;            
                    if($i>0)// if i=0, assummed 0 for $previous_month_FWh
                        $previous_month_FWh=$res[$i-1]->FWh > 0 ? $res[$i-1]->FWh : $previous_month_FWh;            
                    if($current_month_FWh<=0)
                        $current_month_FWh=$previous_month_FWh;

                    $diff_value= $current_month_FWh - $previous_month_FWh;
                    $Wh_value=$temp=$diff_value>0 ? $diff_value : $temp;                 
                    $chart_data.=",['".$res[$i]->month."',".round($Wh_value,2)."]";        
                    $total_value+=$Wh_value;
                    $min_value=($Wh_value<$min_value)?$Wh_value:$min_value;
                    $max_value=($Wh_value>$max_value)?$Wh_value:$max_value;
                    $no_of_columns++;
                }
                $chart_data.="]";            
            }
            if($no_of_columns<=1)
                $avg=round($total_value,2); 
            else
                $avg=round($total_value/$no_of_columns,2);  
        }else
            $chart_data=null;   
        // dd($res,$chart_data,$no_of_columns);
        return view('admin.reports.wh_report_by_month',[
            'year'=>$year,
            'devices'=>$devices,
            'chart_data'=>$chart_data,
            'title'=>$title,
            'y_title'=>$y_title,            
            'min_value'=>$this->autoConvertUnit($min_value),
            'max_value'=>$this->autoConvertUnit($max_value),
            'avg'=>$this->autoConvertUnit($avg),
            'total_value'=>$this->autoConvertUnit($total_value),            
            'locations'=>$locations,
            'selected_location'=>$selected_location,
            'selected_device'=>$selected_device]);
    }

    public function showExcelExport()
    {
        $export_column_pref=[];
        $devices=$this->deviceRepo->getAllForSelectBox($id='id',$value='name');
        $selected_device_id=0;
        if(isset($request->device_id))
            $selected_device_id=$request->device_id;
        $res=$this->settingRepo->getDataExportColumn();        
        foreach ($res as $key => $value)
            $export_column_pref[$value]=$value;        
        $end_date=$start_date=date('d-m-Y');
        return view('admin.reports.excel_export',compact('devices','selected_device_id','export_column_pref','start_date','end_date'));
    }

    public function exportExcel(Request $request)
    {        
        $selected_columns='A,A1,A2,A3,VLL,VLN,V12,V23,V31,V1,V2,V3,W,W1,W2,W3,VAR,VAR1,VAR2,VAR3,VA,VA1,VA2,VA3,PF,PF1,PF2,PF3,F,FVAh,FWh,FVARh,RVAh,RWh,RVARh,OnH,FRun,RRun,INTR,PD,RD,MaxMD,MaxDM';                
        if(count($request->checked_columns)>0){
            $selected_columns=implode(",",$request->checked_columns);            
            $jsonStr=json_encode($request->checked_columns);
            $res=$this->settingRepo->getByUserId(\Auth::user()->id);                  
              if(count($res)<=0)
              {//create export column setting first
                $data=['user_id'=>\Auth::user()->id,'exportColumnPref'=>$jsonStr];
                $setting=$this->settingRepo->create($data); 
              }else{// update export column setting first
                $res=$this->settingRepo->update(['exportColumnPref'=>$jsonStr],$res[0]->id);
              }
        }
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        $data_rows=$this->deviceDetailRepo->getDataForExport($request->device_id,$start_date,$end_date,$selected_columns);
        $columns=explode(",",$selected_columns);
        $device_name=$this->deviceRepo->getById($request->device_id)->name;
        if(count($data_rows)>0){
            \Excel::create('Electrical Usage Data',function($excel) use($data_rows,$columns,$start_date,$end_date,$device_name){
                $excel->sheet('Sheet',function($sheet) use($data_rows,$columns,$start_date,$end_date,$device_name){
                    $sheet->loadView('admin.reports.export_template',['data_rows'=>$data_rows,'columns'=>$columns
                        ,'start_date'=>$start_date,'end_date'=>$end_date,'device_name'=>$device_name]);
                });
            })->export('xls');
            toast()->success('Export success.');
        }else
            toast()->error('Empty data to export.');
        return redirect()->back()->withInput();        
    }

    public function autoConvertUnit($value)
    {
         if($value<1000)
            $value=round($value,2).' W';
        else if ($value>1000 && $value<1000000)
            $value=round(($value/1000),2).' kW';
        else if ($value>1000000 && $value<1000000000)
            $value=round(($value/1000000),2).' mW';
        else if ($value>1000000000 && $value<1000000000000)
            $value=round(($value/1000000000),2).' gW';
        return $value;
    }

}
