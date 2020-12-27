<?php

namespace App\Http\Controllers\Api\V1\Slot;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\TimeSlot;

class ManageSlotController extends ApiController
{
    public function index(Request $request){
        $this->authorize('all', TimeSlot::class);

        $perPageRecords = $request->has('per_page') ? $request->per_page : $this->pageLimit;

        $slots = TimeSlot::orderBy('created_at','desc');

        if ($request->exists('nopaging')) {
            $slots = $slots->get();
        } else {
            $slots = $slots->paginate($perPageRecords);
        }

        return $this->respondWithData($slots->toArray());
    } 
}
