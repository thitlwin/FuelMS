<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\MyLibs\Models\Range;
use PowerMs\MyLibs\Repositories\BaseRepository;

class RangeRepository extends BaseRepository {

	protected $model;
	public function __construct(Range $model)
	{
		$this->model = $model;
	}

	

}