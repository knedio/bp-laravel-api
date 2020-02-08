<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Model\User;
use App\Model\UserDetail;

class ResetPasswordForgotPasswordController extends Controller
{
    /**
     * Reset the user password via forgot password.
     *
     * @author Karl Edio
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        try { 
            $token_exist = DB::table('password_resets')
                ->where('email',$request->email)
                ->where('token',$request->password_token)
                ->first();

            if(!$token_exist) {
                return response([
                    'message'	=> "The reset credentials doesn't exist or already expired!"
                ], 404);
            }

            $user = User::where('email',$request->email)->first();
            $user->update([
                'password'  => bcrypt($request->new_password)
            ]);

            return response([
                'message'   => 'Successful! Updating the user password via forgot password.'
            ],200);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            
            return response([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }
}
