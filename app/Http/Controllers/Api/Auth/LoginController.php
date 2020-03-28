<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Model\User;
use App\Model\UserDetail;
use Auth;

class LoginController extends Controller
{
    /**
     * Verify the user credentials.
     *
     * @author Karl Edio
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request) 
    {
        try { 
            $user = User::where('email', $request->email)->first();
            
            if(!$user) {
                return response([
                    'message'   => "The user doesn't exist."
                ], 404);
            }

            $check_user = Auth::attempt([
                'email'     => $request->email, 
                'password'  => $request->password, 
            ]);

            if(!$check_user) {
                return response([
                    'message'   => 'Email Address or Password is incorrect! Please try again.'
                ], 404);
            } 

            return response([
                'token'     => $user->createToken('Laravel Password Grant Client')->accessToken,
                'user'      => User::show($user->id),
                'message'   =>'Successful! User logged in.'
            ], 200);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            
            return response([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
        
    }
}
