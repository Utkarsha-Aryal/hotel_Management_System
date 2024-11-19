<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DocumentRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'details' => 'nullable|max:255',
            'order' => 'required|integer|min:1|max:99999'
        ];
        if ($post['id'] == null) {
            $rules['file'] = 'required|mimes:pdf|max:2048';
        } else {
            $rules['file'] = 'nullable|mimes:pdf|max:2048';
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'Please enter a title.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least 5 characters long.',
            'title.max' => 'The title must not exceed 255 characters.',
            // order
            'order.required' => 'Please enter order',
            'order.max_digits' => 'Order max is  99999.',
            'order.integer' => 'Order must be a whole number.',
            'order.min' => 'Order at must be 1 or greater than 1.',
            // details
            'details.string' => 'The details must be a string.',
            'details.min' => 'The details must be at least 5 characters long.',
            'details.max' => 'The details must not exceed 5000 characters.',
            'file.required' => 'The file must be mentioned',
            'file.mimes' => 'The file must be a pdf'
        ];
    }
}
