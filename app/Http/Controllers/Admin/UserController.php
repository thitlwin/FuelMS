<?php

namespace PowerMs\Http\Controllers\Admin;

use Illuminate\Http\Request;
use PowerMs\MyLibs\Repositories\UserRepository;
use PowerMs\MyLibs\Repositories\UserTypeRepository;
use PowerMs\MyLibs\Repositories\DeviceRepository;

use PowerMs\Http\Requests\UserRequest;
use PowerMs\Http\Controllers\Controller;
use JsValidator;
use Charts;

class UserController extends Controller
{
   protected $userRepo,$userTypeRepo,$deviceRepo;
    public function __construct(UserRepository $userRepo,
        UserTypeRepository $userTypeRepo,DeviceRepository $deviceRepo)
    {                
        $this->userRepo=$userRepo;
        $this->userTypeRepo=$userTypeRepo;
        $this->deviceRepo=$deviceRepo;
    }
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {       
        //$users=$this->userRepo->getPaginated();
        $users=$this->userRepo->getAll();
        $user_types=$this->userTypeRepo;  
        return view('admin.user.index',compact('users','user_types'));
    }

    public function showUserOf($user_id)
    {
        $users=$this->userRepo->getAllUserOf($user_id);
        $user_types=$this->userTypeRepo;
        return view('admin.user.index',compact('users','user_types'));
    }

     public function create()
    {        
        if(\Auth::user()->user_type_id==2)// admin
            $user_types=$this->userTypeRepo->getAll()->toArray();          
        elseif (\Auth::user()->user_type_id>=3) {// manager
            $user_types=$this->userTypeRepo->getAllButNotAdmin()->toArray();          
        }
        $devices=$this->deviceRepo->getAllForSelectBox('id','name');
        return view('admin.user.create',compact('user_types','devices'));
    }

    public function save(Request $request)
    {
        $data=$request->all();//dd($data);
        if ($request->user_type_id == 3) {
            $data['agent_id']= \Auth::user()->id;
        }else{
        $data['agent_id']=0;
          }
        
         $data['nrc']= $data['state_code'].'/'.$data['city_code'].'(N)'.$data['nrc_number'];                     
        // check nrc unique
        $validator= \Validator::make($data,['nrc'=>'unique:users,nrc']);
        if($validator->fails()){
            toast()->error('NRC has already exist.');
            return redirect()->back()->withInput();
        }
        $validator= \Validator::make($data,['login_name'=>'unique:users,login_name']);
        if($validator->fails()){
            toast()->error('Login name has already taken.');
            return redirect()->back()->withInput();
        }
        $validator= \Validator::make($data,['email'=>'unique:users,email']);
        if($validator->fails()){
            toast()->error('Email has already taken.');
            return redirect()->back()->withInput();
        }

        try{
            $data['password']=\Hash::make($request->password);
            $user=$this->userRepo->create($data);
            //attatch user-device pivot table here
            $device_ids=$this->deviceRepo->getAllDeviceIDs();
            if($user->user_type_id==2)//admin user
                $user->devices()->attach((array)$device_ids);
            else{// if user, check allowed devices Id
                $allowed_device_ids=[];
                foreach ($device_ids as $id) {
                    $input_name='device_'.$id;
                    if(isset($request->$input_name))
                        $allowed_device_ids[]=$id;
                }
                if(count($allowed_device_ids)>0)
                    $user->devices()->attach($allowed_device_ids);
            }
            \Log::info(\Auth::user()->login_name.' create user '.$user->login_name.'(id='.$user->id.')');
        }catch(\Exception $e){
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }        
        toast()->success('User has successfully created.');
        return redirect()->back();
    }

    public function edit(Request $request)
    {            
        $allowed_device_ids=[];
        $user = $this->userRepo->getById($request->id);
        $nrc=explode("/", $user->nrc);
        $user->state_code=$nrc[0];
        $code=explode("(N)", $nrc[1]);
        $user->city_code=$code[0];
        $user->nrc_number=$code[1];        
        
        if(\Auth::user()->user_type_id==2)// admin
            $user_types=$this->userTypeRepo->getAll()->toArray();          
        elseif (\Auth::user()->user_type_id>=3) {
            $user_types=$this->userTypeRepo->getAllButNotAdmin()->toArray();   
        }
        $devices=$this->deviceRepo->getAllForSelectBox('id','name');
        if(count($devices)>0){
            if($user->user_type_id==2)
                $allowed_device_ids=array_keys($devices);
            else{
                $allowed_devices=$user->devices()->get();
                if(count($allowed_devices)>0){
                    $allowed_device_ids=array_pluck($allowed_devices,'id');
                }
            } 
        }            
        return view('admin.user.edit',compact('user_types','user','devices','allowed_device_ids'));
    }

    public function update(Request $request)
    {        
       $data=$request->all();   
       if ($request->user_type_id == 3) {
            $data['agent_id']= \Auth::user()->id;
        }else{
        $data['agent_id']=0;
          } 
       $data['nrc']= $data['state_code'].'/'.$data['city_code'].'(N)'.$data['nrc_number'];             
        try{
            $this->userRepo->update($data,$data['id']);            
            //attatch user-device pivot table here
            $user=$this->userRepo->getById($data['id']);
            $device_ids=$this->deviceRepo->getAllDeviceIDs();
            if($user->user_type_id==2)//admin user
            {
               $user->devices()->detach((array)$device_ids);
               $user->devices()->attach((array)$device_ids);
           }else
           {// if user, check allowed devices Id
                \DB::delete('delete from user_device where user_id = ?', [$user->id]);
                $allowed_device_ids=[];
                foreach ($device_ids as $id) {
                    $input_name='device_'.$id;
                    if(isset($request->$input_name))
                        $allowed_device_ids[]=$id;
                }
                if(count($allowed_device_ids)>0)
                    $user->devices()->attach($allowed_device_ids);
            }
            \Log::info(\Auth::user()->login_name.' updated user.'.$data['login_name'].'(id='.$data['id'].')');
        }catch(\Exception $e){           
        
            $err_msg=substr($e->getMessage(), strpos($e->getMessage(), "Duplicate"), strpos($e->getMessage(), "for") - strpos($e->getMessage(), "Duplicate"));
            toast()->error($err_msg);
            return redirect()->back()->withInput();
        }        
        toast()->success('Successfully updated.');
        return redirect()->back();
    }


    public function deleteUser(Request $request)
    {        
        $id=$request->input('user_id');              
         try{
            $users=$this->userRepo->delete($id);        
        }catch(\Exception $e){
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }        
        toast()->success('User has successfully deleted.');
        return redirect()->back();
    }

    public function showProfile()
    {
        $user=\Auth::user();
        $nrc=explode("/", $user->nrc);
        $user->state_code=$nrc[0];
        $code=explode("(N)", $nrc[1]);
        $user->city_code=$code[0];
        $user->nrc_number=$code[1];        
        
        if(\Auth::user()->user_type_id==2)// admin
            $user_types=$this->userTypeRepo->getAll()->toArray();          
        elseif (\Auth::user()->user_type_id>=3) {// manager
            $user_types=$this->userTypeRepo->getAllButNotAdmin()->toArray();          
        }
        return view('admin.user.profile',compact('user','user_types'));
    }

    public function updatePassword(Request $request)
    {     
        // dd($request->all());
        if(\Hash::check($request->current_password, \Auth::user()->password))
        {
             try{
                $this->userRepo->update(['password'=>\Hash::make($request->new_password)],\Auth::user()->id);
                toast()->success('Password change success.');
            }catch(\Exception $e){           
                toast()->error($e->getMessage());
                return redirect()->back()->withInput();
            }  
        }else{
            toast()->error('Your current password is wrong.');
        }
        return redirect()->back();
    }

    public function changePassword(Request $request)//Admin change user's password
    {      
        try{
                $this->userRepo->update(['password'=>\Hash::make($request->new_password)],$request->id);
                toast()->success('Password change success.');
            }catch(\Exception $e){           
                toast()->error($e->getMessage());
                return redirect()->back()->withInput();
            }  
        //toast()->success('Password change success');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        try{
            $this->userRepo->delete($request->id);
            \Log::info(\Auth::user()->login_name.' deleted user.(id='.$request->id.')');   
            toast()->success('User has been successfully deleted.');
        }catch(\Exception $e)
        {
            toast()->error($e->getMessage());
        }
        return redirect()->back();
    }

    public function showUserRegisterationGraph(Request $request)
    {

        $years=[];
        for($i=2015; $i<=2050; $i++)
            $years[$i]=$i;
        if(request()->selected_year)
            $selected_year=request()->selected_year;
        else
            $selected_year=date('Y');
        $data=$this->userRepo->getUserCountForEachMonth($selected_year);        
        $labels=['January','Feburary','March','April','May','June','July','August','September','October','November','December'];
       
        $line_chart = Charts::create('line', 'highcharts')
            ->title('User Registeration')
            ->elementLabel('Count')
            ->labels($labels)
            ->values($data)
            ->dimensions(1000,500)
            ->responsive(true);                

        $donut_chart=Charts::create('donut', 'highcharts')
              ->title('User Registeration')
              ->labels($labels)
              ->values($data)
              ->dimensions(1000,500)
              ->responsive(true);

        $bar_chart = Charts::create('bar', 'highcharts')
                ->title('User Registeration')
                ->elementLabel('Count')
                ->labels($labels)
                ->values($data)
                ->dimensions(1000,500)
                ->responsive(true);

         return view('admin.user.graph', ['bar_chart' => $bar_chart,
        'line_chart'=>$line_chart,
        'donut_chart'=>$donut_chart,
        'years'=>$years,
        'selected_year'=>$selected_year]);
    }

     public function agent()
    { 
        $users=$this->userRepo->getAllAgent(\Auth::user()->id);
        $user_types=$this->userTypeRepo;
        return view('admin.user.agent',compact('users','user_types'));
    }

}