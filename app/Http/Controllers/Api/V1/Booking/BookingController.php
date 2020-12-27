<?php

namespace App\Http\Controllers\Api\V1\Booking;

use App\Http\Requests\Api\V1\Booking\AddBookingTicketRequest;
use App\Http\Controllers\Api\ApiController;
use App\Models\Show;
use App\Models\Booking;
use DB;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends ApiController
{
    public function doBooking(AddBookingTicketRequest $request){
        $params = $request->only('required_seats','show_id');

        $show = Show::where('id', $request->show_id)->first();

        if(!$show){
            return $this->setStatusCode(413)->respondWithError(['Show no more exists !']);
        }

        $bookedSeats = $show->booked_seats ?? 0;

        if($bookedSeats == $show->total_seats){
            return $this->setStatusCode(413)->respondWithError(['Show is running full. You can not book ticket for this Show !']);
        }

        $availableSeats = $show->total_seats - $bookedSeats;

        if($params['required_seats'] > $availableSeats){
            return $this->setStatusCode(413)->respondWithError(["Only {$availableSeats} seat(s) are free."]);
        }

        DB::beginTransaction();

        $booking = new Booking;
        $booking->user_id = $request->user()->id;
        $booking->booked_seats = $params['required_seats'];
        $booking->show_id = $params['show_id'];

        if(!$booking->save()){
            DB::rollback();
            return $this->respondDataNotSaved();
        }

        $bookedSeats += $booking->booked_seats; 

        $show->booked_seats = $bookedSeats;

        if(!$show->save()){
            DB::rollback();
        }

        DB::commit();

        $responseArray = array_merge(['bookingData' => $booking->toArray()],['showData' => $show->toArray()]);

        return $this->setStatusCode(200)->respondWithData($responseArray,'Ticket Successfully Booked!');
    }

    public function showMyBookings(Request $request){

        $perPageRecords = $request->has('per_page') ? $request->per_page : $this->pageLimit;

        $bookings = Booking::with(['show.timeSlot','show.movie','show.theatre'])
        ->whereHas('show.timeSlot')
        ->whereHas('show.movie')
        ->whereHas('show.theatre')
        ->orderBy('created_at','desc')
        ->where('user_id', $request->user()->id);

        if ($request->exists('nopaging')) {
            $bookings = $bookings->get();
        } else {
            $bookings = $bookings->paginate($perPageRecords);
        }

        return $this->respondWithData($bookings->toArray());
    }
}
