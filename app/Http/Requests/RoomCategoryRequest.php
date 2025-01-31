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
        $post = $request->all();
        $rules = [
            'category'=> 'required|min:3|max:255',
            'order'=>'required|numeric|min:1|max_digits:5',
            'bed_type' => 'required|in:Single Bed,Double Bed,Queen Bed,King Bed,Twin Bed',
        ];
        if ($post['id'] == null) {
            $rules['image'] = 'required|mimes:jpg,jpeg,png|max:512';
        } else {
            $rules['image'] = 'nullable|mimes:jpg,jpeg,png|max:512';
        }
        return $rules;
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

        'bed_type.required' => "The bed type is required please select a valid option",
        'bed_type.in' => 'Please select a valid option among the options given '
        ];

    }
}
