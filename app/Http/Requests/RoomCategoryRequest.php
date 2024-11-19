<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomCategoryRequest extends FormRequest
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
        return [
            'category'=> 'required|min:3|max:255',
            'order'=>'required|numeric|min:1|max_digits:5',
            'image'=>'required|mimes:jpg,jpeg,png|max:512',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return [
        'category.required' => 'The category field is required.',
        'category.min' => 'The category must be at least 3 characters.',
        'category.max' => 'The category may not be greater than 255 characters.',
        
        'order.required' => 'The order field is required.',
        'order.numeric' => 'The order must be a number.',
        'order.min' => 'The order must be at least 1.',
        'order.max_digits' => 'The order may not have more than 5 digits.',
        
        'image.required' => 'An image is required.',
        'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
        'image.max' => 'The image size may not exceed 512KB.',
        
        'price.required' => 'The price field is required.',
        'price.numeric' => 'The price must be a number.',
        'price.regex' => 'The price must be a number with up to two decimal places.',

        ];

    }
}
