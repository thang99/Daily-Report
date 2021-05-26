<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreUserRequest extends FormRequest
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
        $dt = new Carbon();
        $before = $dt->subYears(18)->format('m/d/Y');
        return [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:10',
            'birthday' => 'required|date|before:' . $before,
            'status' => 'required',
            'password' => 'required|min:7',
            'confirm_password' => 'required|same:password',
            'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'role' => 'required'
        ];
    }
}
