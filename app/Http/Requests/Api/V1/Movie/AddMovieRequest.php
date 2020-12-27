<?php

namespace App\Http\Requests\Api\V1\Movie;

use Illuminate\Foundation\Http\FormRequest;

class AddMovieRequest extends FormRequest
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
            'movie_name' => 'required',
            'genre' => 'required',
            'description' => 'required',
            'releasing_date' => 'required|date',
            'file' => 'required|image|mimes:jpeg,bmp,jpg,png|max:250'
        ];
    }
}
