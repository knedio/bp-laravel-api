<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email'             => 'Email Address',
            'new_password'      => 'New Password',
            'confirm_password'  => 'Confirm Password',
            'password_token'    => 'Password Token',
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
            'email'             => 'required|email|exists:users,email',
            'new_password'      => 'required', 
            'confirm_password'  => 'required|same:new_password', 
            'password_token'    => 'required|exists:password_resets,token', 
        ];
    }
}
