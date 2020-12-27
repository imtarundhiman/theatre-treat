<?php

namespace App\Http\Controllers\Api\V1\Theatre;

use App\Http\Requests\Api\V1\Theatre\AddTheatreRequest;
use App\Http\Controllers\Api\ApiController;
use App\Models\Theatre;
use Symfony\Component\HttpFoundation\Request;

class ManageTheatreController extends ApiController
{

    public function index(Request $request){
        $this->authorize('all', Theatre::class);

        $perPageRecords = $request->has('per_page') ? $request->per_page : $this->pageLimit;

        $theatres = Theatre::orderBy('created_at','desc');

        if ($request->exists('nopaging')) {
            $theatres = $theatres->get();
        } else {
            $theatres = $theatres->paginate($perPageRecords);
        }

        return $this->respondWithData($theatres->toArray());
    } 

    public function store(AddTheatreRequest $request){

        $this->authorize('all', Theatre::class);

        $params = $request->only('theatre_name','theatre_address','theatre_description','total_seats');

        $theatre = new Theatre;

        $theatre->theatre_name = $params['theatre_name'];
        $theatre->theatre_address = $params['theatre_address'];
        $theatre->theatre_description = $params['theatre_description'];
        $theatre->total_seats = $params['total_seats'];

        if(!$theatre->save()){
            return $this->respondDataNotSaved();
        }

        return $this->setStatusCode(200)->respondWithData($theatre->toArray(),'successfully saved !');
    }
}
