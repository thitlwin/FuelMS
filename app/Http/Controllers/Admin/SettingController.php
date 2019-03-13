<?php

namespace PowerMs\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PowerMs\Http\Requests;
use PowerMs\Http\Controllers\Controller;
use PowerMs\MyLibs\Repositories\SettingRepository;
use PowerMs\Http\Requests\SettingRequest;
use PowerMs\MyLibs\Models\Setting;
use PowerMs\MyLibs\Repositories\DashboardSettingRepository;
use Validator;
use input;


class SettingController extends Controller
{
    public function __construct(SettingRepository $settingRepo,DashboardSettingRepository $dashboardSettingRepo)
	{
		$this->settingRepo=$settingRepo;
		$this->dashboardSettingRepo = $dashboardSettingRepo;
	}
	public function deviceCreate()
	{
		$dev=[];
		$res=$this->settingRepo->getDeviceSettings();
    if(count($res) > 0 )
    {
          $settings=json_decode($res[0]->devicePref);
          if(count($settings) > 0){
            $setting_id = \Auth::id();
            foreach ($settings as $key => $value)
            $dev[$value]=$value;
          }else{
            $setting_id = \Auth::id();
            $dev=[ "A" => "A","VLL" => "VLL","W" => "W","VA" => "VA","PF" => "PF","F" => "F","FVAh" => "FVAh","PD" => "PD"];
          }
      
    }else{
      $setting_id = \Auth::id();
      $dev=[ "A" => "A","VLL" => "VLL","W" => "W","VA" => "VA","PF" => "PF","F" => "F","FVAh" => "FVAh","PD" => "PD"];
    }
      return view('admin.settings.deviceCreate',compact('settings','setting_id','dev'));
	}
	public function reportCreate()
	{
		$dev=[];
		$res=$this->settingRepo->getDeviceSettings();  
		$settings=json_decode($res[0]->reportPref);
		$setting_id=$res[0]->id;
		foreach ($settings as $key => $value)
			$dev[$value]=$value;
        return view('admin.settings.reportCreate',compact('settings','setting_id','dev'));
	}
	
	public function deviceSave(Request $request)
	{
		$form_data=$request->except('_token');
    
   
         $data['user_id']=\Auth::user()->id;
           $data['devicePref']=json_encode($form_data);
            $res=(array)json_decode($data['devicePref']);
            if(count($res) >= 12)
            {
              return redirect('/control-panel/device_settings')->with('res', 'You must select at most ten');
            }
        try{ 
             $getDevice=$this->settingRepo->getSetting();
            if(count($getDevice) > 0){   
               $setting_id=$getDevice[0]->id;   
               $this->settingRepo->update($data,$setting_id);
             }else{
               $this->settingRepo->create($data);
             }
              \Log::info(\Auth::user()->login_name.' has updated setting.json='.$data['devicePref']);
          }catch(\Exception $e){            
              toast()->error($e->getMessage());
              return redirect()->back()->withInput();
          }        
        
         toast()->success(' Device setting has successfully update.');
            return redirect()->back()->withInput();
		 

	}
	public function reportSave(Request $request)
	{
		
		$form_data=$request->except('_token');
		 $data_report['user_id']=\Auth::user()->id;
         $data_report['reportPref']=json_encode($form_data);
             
		  try{            
             $this->settingRepo->update($data_report,$request->id);
            \Log::info(\Auth::user()->login_name.' has updated setting.json='.$data_report['reportPref']);
        }catch(\Exception $e){            
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }        
		  
		 toast()->success(' Report setting has successfully update.');
        return redirect()->back()->withInput();

	}
	
	 public function wifiSetting()
    {
         return view("admin.settings.wifiSetting");
    }

    public function dashboardSetting()
    {
       $dashboardSetting = $this->dashboardSettingRepo->getByUserId();
       return view('admin.settings.dashboardSetting',compact('dashboardSetting'));
    }

    public function updateDashboardSetting(Request $request)
    {
    	$data=$request->all(); 
      $dashboardSetting = \DB::select('select * from dashboard_setting where user_id = ?', [\Auth::id()]);
        try{
              if(count($dashboardSetting) > 0){
                $this->dashboardSettingRepo->update($data,$dashboardSetting[0]->id);
                 \Log::info(\Auth::user()->login_name.' has updated dashboard setting. id='.$dashboardSetting[0]->id);
              }else{

                 $data['user_id'] = \Auth::id();
                 $data['selected_device_id'] = 1;
                 $dashboard_created_data=$this->dashboardSettingRepo->create($data);
                  \Log::info(\Auth::user()->login_name.' has updated dashboard setting. id='.$dashboard_created_data['id']);
              }
            
        }catch(\Exception $e){           
            if(strpos($e->getMessage(), 'Duplicate'))
                $err_msg=substr($e->getMessage(), strpos($e->getMessage(), "Duplicate"), strpos($e->getMessage(), "for") - strpos($e->getMessage(), "Duplicate"));
            else
                $err_msg=$e->getMessage();
            toast()->error($err_msg);
            return redirect()->back()->withInput();
        }        
        toast()->success('Dashboard Setting has successfully updated.');
       
        return redirect()->back();
    }

    public function showUnitSetting()
    {
        $selected_dashboard_unit=$this->settingRepo->getMeasureUnitForDashboard();
        $selected_wh_unit=$this->settingRepo->getMeasureUnitForWh();
        $selected_w_unit=$this->settingRepo->getMeasureUnitForW();
        return view('admin.settings.unitSetting',compact('selected_wh_unit','selected_w_unit','selected_dashboard_unit'));

    }

    public function updateUnitSetting(Request $request)
    {
      $arr=['w_report_unit'=>$request->w_report_unit,'wh_report_unit'=>$request->wh_report_unit,'dashboard_unit'=>$request->dashboard_unit];
      $jsonStr=json_encode($arr);            
      $res=$this->settingRepo->getByUserId(\Auth::user()->id);
      if(count($res)<=0)
      {//create
        $data=['user_id'=>\Auth::user()->id,'unitPref'=>$jsonStr];
        $setting=$this->settingRepo->create($data);
        toast()->success('Unit Setting has successfully updated.');
        \Log::info(\Auth::user()->login_name.' has updated unit setting. id='.$setting->id);
      }else{//update
        $setting=$res[0];
        $data=['unitPref'=>$jsonStr];
        $this->settingRepo->update($data,$setting->id);
        toast()->success('Unit Setting has successfully updated.');
        \Log::info(\Auth::user()->login_name.' has updated unit setting. id='.$setting->id);
      }
      return redirect()->back();
    }

}
