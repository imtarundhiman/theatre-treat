<?php

namespace App\Http\Requests\Api\V1\Booking;

use Illuminate\Foundation\Http\FormRequest;

class AddBookingTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'required_seats' => 'required|min:0',
            'show_id' => 'required|exists:shows,id'
        ];
    }
}
