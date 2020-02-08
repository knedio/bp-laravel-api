<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use App\Model\User;
use App\Model\UserDetail;

class ForgotPasswordController extends Controller
{
    /**
     * For creating a link for forgot password.
     *
     * @author Karl Edio
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ForgotPasswordRequest $request) 
    {
        try { 
            $user = User::with('detail')
                ->where('email', $request->email)
                ->first();

            $reset_record = DB::table('password_resets')
                ->where('email', $request->email)
                ->delete();

            $token = Hash::make($user);

            $add_reset_record = DB::table('password_resets')->insert([
                'email'			=> $request->email,
                'token'			=> $token,
                'created_at'	=> date('Y-m-d H:i:s')
            ]);

            Mail::to($user->email)->send(new ResetPasswordMail([
                'token'			=> $token,
                'first_name'	=> $user->detail->first_name,
                'url'			=> env('WEB_APP').'/forgot-password/' . urlencode($token)
            ]));

            return response([
                'token'		=> $token,
                'message'   => 'Successful! Creating a link for forgot password.'
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
