<?php

namespace PowerMs\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PowerMs\Http\Requests;
use PowerMs\Http\Controllers\Controller;
use PowerMs\MyLibs\Repositories\RangeRepository;
use PowerMs\Http\Requests\RangeRequest;

class RangeController extends Controller
{
     protected $rangeRepo;
    public function __construct(RangeRepository $rangeRepo)
    {                
        $this->rangeRepo=$rangeRepo;
    }

     public function create()
    {
       return view("admin.range.create");
    }

    public function index()
    {
    	$range=$this->rangeRepo->getAll();

    	return view('admin.range.index',compact('range'));
    }

    public function save(RangeRequest $request)
    {
    	$data=$request->all(); 


        try{            
            $res=$this->rangeRepo->create($data);
            
        }catch(\Exception $e){            
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }        
        toast()->success('Range has successfully created.');
        \Log::info(\Auth::user()->login_name.' has created range type. id='.$res->id);
        return redirect()->back();     
    }

    public function edit(Request $request)
    { 

     $range_edit = $this->rangeRepo->getById($request->id);


     return view('admin.range.edit',compact('range_edit'));

    }

    public function update(Request $request)
    {
      $data=$request->all();        
      // dd($data);
        try{
            $this->rangeRepo->update($data,$data['id']);
        }catch(\Exception $e){           
            if(strpos($e->getMessage(), 'Duplicate'))
                $err_msg=substr($e->getMessage(), strpos($e->getMessage(), "Duplicate"), strpos($e->getMessage(), "for") - strpos($e->getMessage(), "Duplicate"));
            else
                $err_msg=$e->getMessage();
            toast()->error($err_msg);
            return redirect()->back()->withInput();
        }        
        toast()->success('Range has successfully updated.');
        \Log::info(\Auth::user()->login_name.' has updated range. id='.$data['id']);
        return redirect()->back();

    }

    public function delete(Request $request)
    {

     $id=$request->input('id');
               
         try{
            $this->rangeRepo->delete($id);        
        }catch(\Exception $e){
            toast()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
        toast()->success('Range  has successfully deleted.');
        \Log::info(\Auth::user()->login_name.' has deleted range. id='.$id);
        return redirect()->back();
   }   

}
