<?php

namespace PowerMs\Mylibs\Models;

use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    public $table="ranges";
    public $fillable=['unit_name','min','max'];
}
 