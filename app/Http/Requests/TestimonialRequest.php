<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|min:5|max:255',
            'review' => 'required|string|min:2|max:5000',
            'order_number' => 'required|integer|min:1',
            'rating' => 'required|numeric|min:1|max:5',
            'designation' => 'required|string|min:3|max:255'
        ];

        return $rules;
    }
    public function messages()
    {
        return [
            // Name
            'name.required' => 'Please enter a name.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least 5 characters long.',
            'name.max' => 'The name must not exceed 255 characters.',

            // Review
            'review.required' => 'Please write a review.',
            'review.string' => 'The review must be a string.',
            'review.min' => 'The review must be at least 2 characters long.',
            'review.max' => 'The review must not exceed 5000 characters.',

            // Rating
            'rating.required' => 'Please give a rating.',
            'rating.string' => 'The rating must be a number.',
            'rating.min' => 'The rating must be at least 1 digits or positive number.',
            'rating.max' => 'The rating must be between  1 to 5.',

            //Order number
            'order_number.required' => 'Please write a order number.',
            'order_number.integer' => 'The order must be a integer.',
            'order_number.min' => 'The order must be at least 1 digits.',

            // Designation
            'designation.required' => 'Please enter a designation.',
            'designation.string' => 'The designation must be a string.',
            'designation.min' => 'The designation must be at least 3 characters long.',
            'designation.max' => 'The designation must not exceed 255 characters.',
        ];
    }
}
