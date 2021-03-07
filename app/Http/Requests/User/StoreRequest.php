<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'       => 'required|email|max:255|unique:users',
            'password'    => 'required|min:6',
            'first_name'  => 'required',
            'last_name'   => 'required',
            'type_dni'    => 'required',
            'dni'         => 'required|unique:users'
        ];
    }
}