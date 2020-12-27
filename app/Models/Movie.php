<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;
use App\Models\Show;

class Movie extends Model
{
    public function image(){
        return $this->morphOne(Resource::class, 'resourceable');
    }

    public function shows(){
        return $this->hasMany(Show::class, 'movie_id','id');
    }
}
