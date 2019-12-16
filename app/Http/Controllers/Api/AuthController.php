<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\User;
use App\UserDetail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Auth;

class AuthController extends Controller
{
    public function store (StoreRequest $request) 
    {
        try {
            $user = User::create([
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'remember_token'    => Str::random(10),
            ]);

            $userDetail = UserDetail::create([
                'user_id'       => $user->id,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
            ]);

            $user = User::get($user->id);
                
            $token = $user->createToken('Tokenizer')->accessToken;
            
            return response([
                'user'      => $user,
                'message'   => 'Successfully created a user.',
                'token'     => $token
            ], 200);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request) 
    {
        try { 
            $user = User::where('email',$request->email)->first();

            $resetRecord = DB::table('password_resets')
                ->where('email', $request->email)
                ->delete();

            $token = Hash::make($user);

            $addResetRecord = DB::table('password_resets')->insert([
                'email'			=> $request->email,
                'token'			=> $token,
                'created_at'	=> date('Y-m-d H:i:s')
            ]);

            Mail::to($user->email)->send(new ResetPasswordMail([
                'token'			=> $token,
                'first_name'	=> $user->first_name,
                'url'			=> env('WEB_APP').'/forgot-password/' . urlencode($token)
            ]));

            return response()->json([
                'action'	=> 'forgot-password',
                'token'		=> $token
            ],200);

        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            
            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try { 
            $tokenExist = DB::table('password_resets')
                ->where('email',$request->email)
                ->where('token',$request->password_token)
                ->first();

            if ($tokenExist) {
                $user = User::with('detail')->where('email',$request->email)->first();
                $user->password = bcrypt(strip_tags($request->new_password));
                $user->save();

                return response()->json([
                    'action'	=> 'reset-password',
                    'user'	    => $user
                ],200);
            }

            return response()->json([
                'message'	=> "The reset credentials doesn't exist or already expired!"
            ],422);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            
            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function login (LoginRequest $request) 
    {
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            if(Auth::attempt([
                'email'     => $request->email, 
                'password'  => $request->password, 
            ])) {

                $token = $user->createToken('Laravel Password Grant Client')->accessToken;

                $user = User::get(Auth::user()->id);

                return response([
                    'token'     => $token,
                    'user'      => $user,
                    'message'   =>'Successfully logged in.'
                ], 200);
            } else {
                return response([
                    'message'=>'The password or email is not correct!'
                ], 422);
            }
        } else {
            return response([
                'message'   => "User doesn't exist."
            ], 401);
        }
    }

    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();
    
        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    
    }
    
}
