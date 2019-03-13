<?php

namespace PowerMs\MyLibs\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model

{
	public $table="locations";
    public $fillable=['location_name'];
}
