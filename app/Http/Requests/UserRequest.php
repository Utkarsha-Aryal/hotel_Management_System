<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(Request $request): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:512',
            'email' => 'required|email|min:4|max:50|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'mobile_number' => 'required|digits:10|numeric',
        ];
    }

    public function messages()
    {
        return [
            'mobile_number.required' => 'The mobile number is required.',
            'mobile_number.digits' => 'The mobile number must be exactly 10 digits.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email format.',
        ];
    }
}
