<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|min:2|max:255',
            'lastname' => 'required|string|min:2|max:255',
            'role' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'country_id' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
