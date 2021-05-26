<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
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
            'name' => 'required|min:5|max:50|',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:7|max:50',
            're_password' => 'required|same:password',
            'phone' => 'required|max:13',
        ];
    }
}

