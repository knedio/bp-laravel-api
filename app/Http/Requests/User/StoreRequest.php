<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Customize Attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name'        => 'First Name',
            'last_name'         => 'Last Name',
            'email'             => 'Email Address',
            'password'          => 'Password',
            'confirm_password'  => 'Confirm Password',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required',
            'confirm_password'  => 'required|same:password', 
        ];
    }
}
