<?php

namespace App\Http\Controllers\Api\V1\Movie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Models\Movie;
use Carbon\Carbon;
use App\Models\Show;

class MovieController extends ApiController
{
    public function movieDetail(Request $request, $movieId){
        $movie = Movie::with(['image'])->whereRaw("id = ? OR slug = ?", [$movieId, $movieId])->first();

        if(!$movie){
            return $this->respondResourceGone();
        }

        return $this->setStatusCode(200)->respondWithData($movie->toArray());
    }

    public function fetchShows(Request $request, $movieId){
        $perPageRecords = $request->has('per_page') ? $request->per_page : $this->pageLimit;
        
        $shows = Show::with(['timeSlot','theatre'])
        ->where('movie_id', $movieId)
        ->whereDate('show_date','>=',Carbon::today()->toDateString())
        ->orderBy('show_date', 'asc')
        ->orderBy('slot_id','asc');

        if ($request->exists('nopaging')) {
            $shows = $shows->get();
        } else {
            $shows = $shows->paginate($perPageRecords);
        }

        return $this->respondWithData($shows->toArray());
    }
}
