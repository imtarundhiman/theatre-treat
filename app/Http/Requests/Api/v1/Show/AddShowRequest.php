<?php

namespace App\Http\Requests\Api\v1\Show;

use Illuminate\Foundation\Http\FormRequest;

class AddShowRequest extends FormRequest
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
            'movie' => 'required|exists:movies,id',
            'theatre' =>  'required|exists:theatres,id',
            'slot' => 'required|exists:time_slots,id',
            'show_date' => 'required|date',
        ];
    }
}
