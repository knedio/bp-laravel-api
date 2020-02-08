<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordToDefaultController extends Controller
{
    /**
     * Reset the user password to default password.
     *
     * @author Karl Edio
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user)
    {
        try {
            $user->update([
                'password'  => bcrypt('secret123!')
            ]);
            
            return response([
                'message'   => 'Successful! Updating the user password to default.',
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
