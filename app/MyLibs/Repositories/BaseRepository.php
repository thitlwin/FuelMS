<?php 
namespace PowerMs\MyLibs\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function __construct(\Model $model)
    {
        $this->model = $model;
    }

    public function getAll($sort_field = 'id', $sort_type = 'asc')
    {
        return $this->model->where('id','>',0)->orderBy($sort_field, $sort_type)->get();
    }

    public function getPaginated($limit = 20)
    {
        return $this->model->latest('id')->paginate($limit);
    }

     public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $model = $this->getById($id);
        $model->fill($data);
        return $model->push();
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function forceDelete($id)
    {
        return $this->model->withTrashed()
                ->where('id', $id)
                ->forceDelete(); 
    }

    public function getCount()
    {
        return $this->model->count();
    }

    public function getTrashed()
    {
        return $this->model->onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
    }

    public function restoreTrash($id)
    {
        return $this->model->where('id', $id)->restore();
    }

    public function getAllForSelectBox($key,$value)
    {
        $data=[];
        $res=$this->model->where('id','>',0)->orderBy('id','desc')->get();
        foreach ($res as $obj) {
            $data[$obj->$key]=$obj->$value;
        }
        return $data;
    }
}