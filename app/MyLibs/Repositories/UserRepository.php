<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\User;
use PowerMs\MyLibs\Repositories\BaseRepository;

class UserRepository extends BaseRepository {

	protected $model;
	public function __construct(User $model)
	{
		$this->model = $model;
	}

    public function getAllAgent($user_id)
    {
        return $this->model->where('id','>',0)->where('agent_id',$user_id)->get();
    }

	public function getUserNameList($user_id)
	{		
		$child_users = $this->model->select('id','agent_id','name','login_name')->where('agent_id',$user_id);
		return $this->model->select('id','agent_id','name','login_name')->where('id',$user_id)
				->union($child_users)->orderBy('id','asc')->get();
	}

    public function getAllUserOf($user_id)
    {
        return $this->model->where('id','>',0)->where('agent_id',$user_id)->get();
    }

	/*public function getAllUser_Except($user_id)
	{
		return $this->model->select('id','name','login_name')->where('id','<>',$user_id)->orderBy('id','asc')->get();
	}*/

	public function getUserCountForEachMonth($year)
    {
        $data=[];
        $sql="SELECT SUM(IF(month = 1, user_count,0)) AS 'January', SUM(IF(month = 2, user_count,0)) AS 'Febuary', 
        SUM(IF(month = 3, user_count,0)) AS 'March', SUM(IF(month = 4, user_count,0)) AS 'April', 
        SUM(IF(month = 5, user_count,0)) AS 'May', SUM(IF(month = 6, user_count,0)) AS 'June', 
        SUM(IF(month = 7, user_count,0)) AS 'July', SUM(IF(month = 8, user_count,0)) AS 'August', 
        SUM(IF(month = 9, user_count,0)) AS 'September', SUM(IF(month = 10, user_count,0)) AS 'October', 
        SUM(IF(month = 11, user_count,0)) AS 'November', SUM(IF(month = 12, user_count,0)) AS 'December', 
        SUM(user_count) as total FROM ( SELECT month(created_at) month, COUNT(*) user_count 
            FROM `users` WHERE year(created_at)=".$year." GROUP BY month) as T";
        $res=\DB::select($sql);       
        $data=[$res[0]->January,$res[0]->Febuary,$res[0]->March,$res[0]->April,$res[0]->May,$res[0]->June,
        $res[0]->July,$res[0]->August,$res[0]->September,$res[0]->October,$res[0]->November,$res[0]->December];        
        return $data;
    } 

    public function getAllUserButNotAgent($sort_field = 'id', $sort_type = 'asc')
    {
        return $this->model->where('agent_id','=', 0)->orderBy($sort_field, $sort_type)->get();
    }
   
}