<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'firstName'    => 'First Name',
            'lastName'     => 'Last Name',
            'email'         => 'Email Address',
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
            'id'            => 'required|exists:users,id',
            'firstName'    => 'required',
            'lastName'     => 'required',
            'email'         => 'required|email|unique:users,email,'.$this->get('id'),
        ];
    }
}
