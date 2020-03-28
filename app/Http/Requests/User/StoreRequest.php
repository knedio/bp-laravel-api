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
            'firstName'        => 'First Name',
            'lastName'         => 'Last Name',
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
            'firstName'        => 'required',
            'lastName'         => 'required',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required',
            'confirmPassword'  => 'required|same:password', 
        ];
    }
}
