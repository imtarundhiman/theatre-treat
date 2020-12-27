<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\Theatre;
use App\Models\TimeSlot;

class Show extends Model
{
    public function movie(){
        return $this->belongsTo(Movie::class, 'movie_id', 'id');
    }

    public function theatre(){
        return $this->belongsTo(Theatre::class, 'theatre_id', 'id');
    }

    public function timeSlot(){
        return $this->belongsTo(TimeSlot::class, 'slot_id', 'id');
    }
    
}
