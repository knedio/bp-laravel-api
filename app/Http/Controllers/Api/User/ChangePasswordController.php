<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    /**
     * Change the user password.
     *
     * @author Karl Edio
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ChangePasswordRequest $request, User $user)
    {   
        try {
            $user->update([
                'password'  => bcrypt($request->new_password)
            ]);

            return response([
                'message'   => 'Successful! Updating the user password.',
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
