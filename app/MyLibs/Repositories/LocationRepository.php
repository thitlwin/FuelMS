<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\MyLibs\Models\Location;
use PowerMs\MyLibs\Repositories\BaseRepository;

class LocationRepository extends BaseRepository {

	protected $model;
	public function __construct(Location $model)
	{
		$this->model = $model;
	}
}