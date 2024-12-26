<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaqCategoryRequest extends FormRequest
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
            'name' =>  [
                'required',
                'min:3',
                'max:255',
                Rule::unique('faq_categories')->where(function ($query) use ($request) {
                    return $query->where('status', 'Y')
                        ->where('id', '!=', $request->id);
                })
            ],
            'order_number' => 'required|numeric|min:1|max_digits:5',
        ];

        return $rules;
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            /* Message for 'name' field*/
            'name.required' => 'FAQ name is required.',
            'name.min' => 'FAQ name must be at least 3 characters long.',
            'name.max' => 'FAQ name must be smaller than 255 characters.',
            'name.unique' => 'FAQ category name must be unique.',

            /* Message for 'order_number' field*/
            'order_number.required' => 'Please enter order number.',
            'order_number.max_digits' => 'Order must be of 5 digits.',
            'order_number.numeric' => 'Order must be a number.',
            'order_number.min' => 'Order must be 1 or greater.',
        ];
    }
}