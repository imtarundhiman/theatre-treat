<?php

namespace App\Http\Controllers\Api\V1\Show;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\v1\Show\AddShowRequest;
use App\Models\Show;
use App\Models\Theatre;

class ManageShowController extends ApiController
{
    public function index(Request $request){
        $this->authorize('all', Show::class);

        $perPageRecords = $request->has('per_page') ? $request->per_page : $this->pageLimit;

        $shows = Show::with(['movie','theatre','timeSlot'])
        ->whereHas('movie')
        ->whereHas('theatre')
        ->whereHas('timeSlot')
        ->orderBy('created_at','desc');

        if ($request->exists('nopaging')) {
            $shows = $shows->get();
        } else {
            $shows = $shows->paginate($perPageRecords);
        }

        return $this->respondWithData($shows->toArray());
    }  

    public function store(AddShowRequest $request){
        $this->authorize('all', Show::class);

        $params = $request->only('movie','theatre','slot','show_date');

        $showDetail = Show::where('movie_id', $params['movie'])
        ->where('theatre_id',$params['theatre'])
        ->where('slot_id',$params['slot'])
        ->whereDate('show_date',$params['show_date'])
        ->first();


        if($showDetail){
            return $this->setStatusCode(413)->respondWithError(["Selected Slot is occupied."]);
        }

        $theatreDetail = Theatre::find($params['theatre']);

        if(!$theatreDetail){
            return $this->setStatusCode(413)->respondWithError(["Selected theatre does not exists."]);
        }

        $show = new Show;
        $show->movie_id = $params['movie'];
        $show->theatre_id = $params['theatre'];
        $show->slot_id = $params['slot'];
        $show->show_date = $params['show_date'];
        $show->total_seats = $theatreDetail->total_seats;


        if(!$show->save()){
            return $this->respondDataNotSaved();
        }

        return $this->setStatusCode(200)->respondWithData($show->toArray(),'Successfully Generated!');
    }
}
