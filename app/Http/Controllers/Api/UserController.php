<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\User;
use App\UserDetail;
use Illuminate\Support\Str;
use Auth;

class UserController extends Controller
{
    public function get($id) 
    {
        try {
            return response()->json([
                'message'   => 'Successfully get user info',
                'user'      => User::get($id),
            ]);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function getAll() 
    {
        try {
            return response()->json([
                'message'   => 'Successfully get all users.',
                'users'     => User::getAll(),
            ]);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function update(UpdateRequest $request, $id) 
    {
        try {
            $user = User::find($id);
            $user->update([
                'email' => $request->email,
            ]);

            $userDetail = UserDetail::where('user_id', $user->id)->first();
            $userDetail->update([
                'first_name'    => $request->first_name,
                'middle_name'   => $request->middle_name,
                'last_name'     => $request->last_name,
                'address'       => $request->address,
                'gender'        => $request->gender,
            ]);

            return response([
                'user'      => User::get($user->id),
                'message'   => 'Successfully updated the user.',
            ], 200);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function resetPasswordDefault($id)
    {
        try {
            $user = User::get($id);
            $user->password = bcrypt('secret');
            $user->save();
            
            return response()->json([
                'message'   => 'Successfully updated the user password to default.',
                'user'      => $user,
            ], 200);

        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function destroy($id) 
    {
        try {
            $user = User::find($id);
            $message = 'Successfully deleted ' . $user->first_name . ' '.  $user->last_name;
            
            $user->status = 0;
            $user->save();

            return response()->json([ 'message' => $message ]);

        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            
            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {   
        try {
            $user = User::get($request->id);
            $user->password = bcrypt(strip_tags($request->new_password));
            $user->save();

            return response()->json([
                'action'    => 'reset-password',
                'user'      => $user
            ],200);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();
            
            return response()->json([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }
}
