<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TeamMemberRequest extends FormRequest
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
            'name' => 'required|max:100',
            'designation' => 'required|max:250',
            'order_number' => 'required|numeric|min:1',
            'facebook_url' => 'nullable|url|min:5|max:255',
            'twitter_url' => 'nullable|url|min:5|max:255',
            'instagram_url' => 'nullable|url|min:5|max:255',
            'phone_number' => 'nullable|digits:10' 
        ];

        return $rules;
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Messages for Name
            'name.required' => 'Please enter the name.',
            'name.max' => 'The name must be smaller than 100 characters.',

            // Messages for Order
            'order_number.required' => 'Please enter the member order.',
            'order_number.numeric' => 'The order must be a number.',
            'order_number.max_digits' => 'Order must be  be 1 digits long.',

            // Messages for Email

            // Messages for Phone number
            'phone_number.digits' => 'The phone number must be exactly 10 digits if provided.',
            'phone_number.numeric' => 'The phone number must be a number.',


            // Messages for Short bio
            'short_bio.min' => 'Short Bio must be 3 characters.',
            'short_bio.max' => 'The order must be less than 50 characters..',

            // Messages for experience
            'experience.min' => 'Experience must be 1 digits long.',

            // Messages for Designation
            'designation.required' => 'Please enter the designation.',
            'designation.max' => 'The designation must be less than 250 characters.',

            // Messages for Facebook URL
            'facebook_url.url' => 'Please enter a valid Facebook URL.',
            'facebook_url.max' => 'The Facebook URL must be samller than 255 characters.',

            
            // Messages for Twitter URL
            'twitter_url.url' => 'Please enter a valid Twitter URL.',
            'twitter_url.max' => 'The Twitter URL must be samller than 255 characters.',

            // Messages for Instagram URL
            'instagram_url.url' => 'Please enter a valid Instagram URL.',
            'instagram_url.max' => 'The Instagram URL must be samller than 255 characters.',

            // Messages for Photo
           
        ];
    }
}
