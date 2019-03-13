<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\MyLibs\Models\UserType;
use PowerMs\MyLibs\Repositories\BaseRepository;

class UserTypeRepository extends BaseRepository {

	protected $model;
	public function __construct(UserType $model)
	{
		$this->model = $model;
	}

	public function getAll($sort_field = 'id', $sort_type = 'asc')
    {
        return $this->model->where('id','>=',2)->where('id','<=',3)->orderBy($sort_field, $sort_type)->get();
    }

    public function getAllButNotAdmin($sort_field = 'id', $sort_type = 'asc')
    {
        return $this->model->where('id','>',3)->orderBy($sort_field, $sort_type)->get();
    }

}