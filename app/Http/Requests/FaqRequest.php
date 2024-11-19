<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:255',
            'order_number' => 'required|numeric|min:1|max_digits:5',
            'question' => 'required|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            /* Message for 'name' field*/
            'name.required' => 'FAQ is required.',
            'name.min' => 'FAQ must be at leaset 3 character long.',
            'name.max' => 'FAQ must be smaller than 255 character long.',

            /* Message for 'order_number' field*/
            'order_number.required' => 'Please enter order',
            'order_number.max_digits' => 'Order must be 5 digits long.',
            'order_number.numeric' => 'Order must be a number.',
            'order_number.min' => 'Order at must be 1 or greater than 1.',

            /* Message for 'question' field*/
            'question.required' => 'Question is required.',
            'question.min' => 'Question must be at leaset 5 character long.',
            'question.max' => 'Question must be smaller than 255 character long.',
        ];
    }
}
