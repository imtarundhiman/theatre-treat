<?php

namespace App\Http\Controllers\Api\V1\Show;
use App\Http\Controllers\Api\ApiController;
use App\Models\Show;
use Symfony\Component\HttpFoundation\Request;

class ShowController extends ApiController
{
    public function FetchShows(Request $request){

        $perPageRecords = $request->has('per_page') ? $request->per_page : $this->pageLimit;

        $show = Show::with(['movie.image','theatre'])->groupBy('movie_id')
        ->whereHas('movie.image')
        ->whereHas('movie.shows.timeSlot');

        if ($request->exists('nopaging')) {
            $show = $show->get();
        } else {
            $show = $show->paginate($perPageRecords);
        }

        return $this->respondWithData($show->toArray());
    }
}
