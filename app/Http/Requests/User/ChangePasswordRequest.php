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
            'current_password'  => 'Current Password',
            'mew_password'      => 'New Password',
            'current_password'  => 'Confirm Password',
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
            'id'                => 'required',
            'current_password'  => 'required|old_password:' . $this->get('id'), 
            'new_password'      => 'required', 
            'confirm_password'  => 'required|same:new_password', 
        ];
    }
}
