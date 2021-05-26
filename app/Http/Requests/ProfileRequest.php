<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $rules = [];
        $birthday = Carbon::now()->subYears(18)->format('d-M-Y');
        $user = User::where('id','=',$this->id)->first();
        if($user->avatar) {
            $rules = [
                'name' => 'required|min:5|max:20',
                'birthday' => 'date|before:'.$birthday,
                'phone' => 'numeric|digits:10',
            ];
        } else {
            $rules = [
                'name' => 'required|min:5|max:20',
                'birthday' => 'date|before:'.$birthday,
                'phone' => 'numeric|digits:10',
                'avatar' => 'required|image|mimes:png,jpg,jpeg'
            ];
        }
        return $rules;
    }
}
