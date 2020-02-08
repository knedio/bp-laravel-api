<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Mode\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $roles = Role::get();
                
            return response([
                'message'   => 'Successful! Getting all the roles.',
                'roles'     => $roles,
            ]);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        try {
            return response([
                'message'   => 'Successful! Getting the role information.',
                'role'      => $role,
            ]);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            $role = Role::create($request->only([
                'name',
                'description',
            ]));
            
            return response([
                'role'      => $role,
                'message'   => 'Successful! Creating a role.',
            ], 200);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Role $role) 
    {
        try {
            $role->update($request->only([
                'name',
                'description',
            ]));

            return response([
                'role'      => Role::get($role->id),
                'message'   => 'Successful! Updating a role.',
            ], 200);
        } catch (Exception $e) {
            $status = 400;

            if ($this->isHttpException($e)) $status = $e->getStatusCode();

            return response([
                'message'   => 'Something went wrong.'
            ], $status); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role) 
    {
        try {
            $role->delete();

            return response([ 
                'message' => 'Successful! Deleting a role.' 
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
