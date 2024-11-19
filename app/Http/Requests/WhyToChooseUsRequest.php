<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class WhyToChooseUsRequest extends FormRequest
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
            'title' => 'required|min:3|max:200',
            'order_number' => 'required|integer|min:1|max:100',
            'description' => 'required|min:5|max:1000',
            'affordability' => 'required|min:5|max:1000',
            'inspiring' => 'required|min:5|max:1000',
        ];

        if ($post['id'] == null) {
            $rules['icon'] = 'nullable|mimes:png|max:512';
        } else {
            $rules['icon'] = 'nullable|mimes:png|max:512';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            /* Message for 'title' field*/
            'title.required' => 'Please enter title',
            'title.min' => 'Title at least 3 characters.',
            'title.max' => 'Title must be smaller than 200 characters.',

            /* Message for 'order_number' field*/
            'order_number.required' => 'Please enter order',
            'order_number.max' => 'Order must be below 100.',
            'order_number.numeric' => 'Order must be a number.',
            'order_number.min' => 'Order at must be 1 or greater than 1.',

            /* Message for 'description' field*/
            'description.required' => 'Please enter description',
            'description.min' => 'Description at least 3 characters.',
            'description.max' => 'Description must be smaller than 1000 characters.',

            /* Message for 'description' field*/
            'description.required' => 'Please enter description',
            'description.min' => 'Description at least 3 characters.',
            'description.max' => 'Description must be smaller than 1000 characters.',

            /* Message for 'affordability' field*/
            'affordability.required' => 'Please enter affordability',
            'affordability.min' => 'Affordability at least 3 characters.',
            'affordability.max' => 'Affordability must be smaller than 1000 characters.',

           
            /* Messages for 'icon' field */
            'icon.mimes' => 'The icon must be a file of png.',
            'icon.max' => 'The icon size should not greater than 0.5MB.',
        ];
    }
}
