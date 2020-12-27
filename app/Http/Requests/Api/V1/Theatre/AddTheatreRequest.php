<?php

namespace App\Http\Requests\Api\V1\Theatre;

use Illuminate\Foundation\Http\FormRequest;

class AddTheatreRequest extends FormRequest
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
            'theatre_name' => 'required',
            'theatre_address' => 'required',
            'theatre_description' => 'required',
            'total_seats' => 'required|numeric|min:1|max:150',
        ];
    }
}
