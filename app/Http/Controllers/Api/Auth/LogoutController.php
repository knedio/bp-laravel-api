<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try { 
            if (!$this->guard()->check()) {
                return response()->json([
                    'message'   => 'No active user session was found.',
                ], 401); 
            } 
            if (null !== $request->user('api') ) {

                $request->user('api')->token()->revoke();
                Auth::guard()->logout();
                Session::flush();
                Session::regenerate();
      
                return response()->json([
                    'message'   => 'Successful! Logging out.',
                ], 200); 
            }
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            
            return response([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
        
    }
    
    protected function guard(){
        return Auth::guard('api');
    }
}
