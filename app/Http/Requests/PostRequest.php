<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'category' => [
                'required',
                Rule::in(['blog', 'news', 'article', 'event', 'notice']),
            ],
            'title' => 'required|string|min:3|max:255',
            'details' => 'required|string',
            'author'=> 'required|string|min:3|max:255',
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
        

            /* message for title */
            'title.required' => 'Please enter title',
            'title.string' => 'The name must be a string.',
            'title.min' => 'The title should be at least 3 characters long.',
            'title.max' => 'The title should not greater than 255 characters.',

            /* message for title */
            'category.required' => 'Please select category',
            'category.integer' => 'Category must be an integer.',

            /* message for details */
            // 'details.required' => 'Please enter details',
            // 'details.min' => 'The details should be at least 3 characters long.',
            // 'details.max' => 'The details should not greater than :max characters.',

            /* Messages for 'image' field */
            'image.required' => 'Thumbnail image is required.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'The image size should not greater than :max KB.',

            'details.required' => 'The content is required.',
            'details.string' => 'The content must be a valid string.',

            'author.required' => 'Please enter author',
            'author.string' => 'The name must be a string.',
            'author.min' => 'The author should be at least 3 characters long.',
            'author.max' => 'The title should not greater than 255 characters.',


        ];
    }
}