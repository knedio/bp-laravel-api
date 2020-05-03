<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'id'                => 'User ID',
            'currentPassword'   => 'Current Password',
            'newPassword'       => 'New Password',
            'confirmPassword'   => 'Confirm Password',
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
            'id'               => 'required',
            'currentPassword'  => 'required|old_password:' . $this->get('id'), 
            'newPassword'      => 'required', 
            'confirmPassword'  => 'required|same:newPassword', 
        ];
    }
}
