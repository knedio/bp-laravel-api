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
            'newPassword'      => 'New Password',
            'confirmPassword'  => 'Confirm Password',
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
            'newPassword'      => 'required', 
            'confirmPassword'  => 'required|same:newPassword', 
            'password_token'    => 'required|exists:password_resets,token', 
        ];
    }
}
