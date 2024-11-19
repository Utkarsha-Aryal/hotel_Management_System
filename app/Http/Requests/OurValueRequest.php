<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;;

class OurValueRequest extends FormRequest
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
        // $post = $request->all();
        $rules =  [
            'title' => 'required|string|min:3|max:255',
            'details' => 'required|string|max:500',
            'order' => 'required|integer|min:1|max:255',
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            // Title
            'title.required' => 'Please enter a title.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least 3 characters long.',
            'title.max' => 'The title must not exceed 255 characters.',

            // Details
            'details.required' => 'Please enter details.',
            'details.string' => 'The details must be a string.',
            'details.max' => 'The details must not exceed 500 characters.',

            // Order
            'order.required' => 'Please enter an order.',
            'order.integer' => 'The order must be a valid number.',
            'order.min' => 'The order must be at least 1.',
            'order.max' => 'The order must not exceed 255.',
        ];
    }
}
