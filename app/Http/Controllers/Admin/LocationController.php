<?php

namespace PowerMs\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PowerMs\Http\Requests;
use PowerMs\Http\Controllers\Controller;
use PowerMs\MyLibs\Repositories\LocationRepository;
use PowerMs\Http\Requests\LocationRequest;

class LocationController extends Controller
{
    protected $locationRepo;
    public function __construct(LocationRepository $locationRepo)
    {                
        $this->locationRepo=$locationRepo;
    }
     public function create()
    {
       return view("admin.location.create");
    }

    public function index()
    {
    	$location=$this->locationRepo->getAll();

    	return view('admin.location.index',compact('location'));
    }

    public function save(LocationRequest $request)
    {
    	$data=$request->all(); 


        try{            
            $res=$this->locationRepo->create($data);
            
        }catch(\Exception $e){            
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }        
        toast()->success('Location has successfully created.');
        \Log::info(\Auth::user()->login_name.' has created location type. id='.$res->id);
        return redirect()->back();     
    }

    public function edit(Request $request)
    { 

     $location_edit = $this->locationRepo->getById($request->id);


     return view('admin.location.edit',compact('location_edit'));

    }

     public function update(LocationRequest $request)
    {
      $data=$request->all();        
        try{
            $this->locationRepo->update($data,$data['id']);
        }catch(\Exception $e){           
            if(strpos($e->getMessage(), 'Duplicate'))
                $err_msg=substr($e->getMessage(), strpos($e->getMessage(), "Duplicate"), strpos($e->getMessage(), "for") - strpos($e->getMessage(), "Duplicate"));
            else
                $err_msg=$e->getMessage();
            toast()->error($err_msg);
            return redirect()->back()->withInput();
        }        
        toast()->success('Location has successfully updated.');
        \Log::info(\Auth::user()->login_name.' has updated location. id='.$data['id']);
        return redirect()->back();

    }

    public function delete(Request $request)
    {
     $id=$request->input('id');              
         try{
            $this->locationRepo->delete($id);        
        }catch(\Exception $e){
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
        toast()->success('Location  has successfully deleted.');
        \Log::info(\Auth::user()->login_name.' has deleted location. id='.$id);
        return redirect()->back();
   }   
}
