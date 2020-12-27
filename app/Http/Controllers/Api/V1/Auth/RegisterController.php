<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use Hash;

class RegisterController extends ApiController
{
    /**
     * Register a user
     */

    public function store(RegisterRequest $request){
        
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);

        if(!$user->save()){
            return $this->respondDataNotSaved();
        }

        return $this->setStatusCode(200)->respondWithData([$user],trans('register.api.v1.success'));
    }
}
