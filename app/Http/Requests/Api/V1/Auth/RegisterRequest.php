<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => array('required','unique:users','regex:'.config('regex.username')),
            'email' => 'required|email|unique:users',
            'mobile' => array('required','unique:users', 'regex:'.config('regex.mobile')),
            'name' => 'required|min:3|max:50',
            'password' => array('required','min:6','regex:'.config('regex.password'))
        ]; 
    }

    public function messages(){
        return [
            'password.regex' => trans('register.api.v1.error.validation.password.regex'),
            'username.regex' => trans('register.api.v1.error.validation.username.regex'),
            'mobile.regex' => trans('register.api.v1.error.validation.mobile.regex')
        ];
    }
}
