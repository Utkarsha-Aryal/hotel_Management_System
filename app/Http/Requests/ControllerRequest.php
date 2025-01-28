<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ControllerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        $post = $request->all();
        $rules = [
            'name'=>'required',
            'phone_number'=>'required',
            'email'=>'required',
            'message'=>'required'

        ];
        return $rules;
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'The message field is required.',
        ];
    }
}
