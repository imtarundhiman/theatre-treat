<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Models\User;
use Auth;

class LoginController extends ApiController
{
    public function login(LoginRequest $request){

        $params = $request->only('username', 'password');
        $username = $params['username'];
        $password =  $params['password'];

        $user = User::where('email', $username)
        ->orWhere('username', $username)
        ->first();

        if(!$user){
            return $this->setStatusCode(403)->respondWithError([trans('login.api.v1.error.validation.username.username_not_exists')]);
        }

        if (!Auth::attempt(['email' => $user->email, 'password' => $password])) {
            return $this->setStatusCode(403)->respondWithError([trans('login.api.v1.error.validation.username.wrong_password')]);            
        }
        
        return $this->setStatusCode(200)->respondWithData(array_merge($user->toArray(),$this->getUserTokenData($user)),trans('login.api.v1.success'));
    }

    protected function getUserTokenData(User $user)
    {
        if (!$user->id) {
            throw new \Exception;
        }

        return ['accessToken' => $user->createToken('user')->accessToken,'expiredAt' => strtotime('+23 hour')];
    }

    public function check(Request $request){
        if(Auth::user()){
            return $this->respondSuccess('User is authenticated !');
        }

        return $this->respondUnauthorized();
    }
}