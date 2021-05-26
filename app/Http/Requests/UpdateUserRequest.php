<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateUserRequest extends FormRequest
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
        $ignore = $this->id;
        return [
            'name' => 'required',
            'phone' => 'required|digits:10',
            'birthday' => 'required|date|before:' . $before,
            'status' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg,gif,svg|max:10000',
            'role' => 'required'
        ];
    }
}
