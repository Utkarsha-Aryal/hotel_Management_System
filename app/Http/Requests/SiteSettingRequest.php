<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|min:3|max:55',
            'phone_number' => 'required|string|min:9|max:50',
            'address' => 'required|string|min:3|max:255',
            'link_facebook' => 'nullable|url|min:5|max:255',
            'link_twitter' => 'nullable|url|min:5|max:255',
            'link_map' => 'nullable|url|min:5|max:1000',
            'link_linkedin' => 'nullable|url|min:5|max:255',
            'office_hour' => 'nullable|string|min:5|max:255',
            'days_of_opening' => 'nullable|string|min:5|max:255',
            'img_logo' => 'nullable|mimes:jpg,jpeg,png|max:512',
            'img_favicon' => 'nullable|mimes:jpg,jpeg,png|max:512',
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Please enter the organization name.',
            'name.string' => 'The organization name must be a string.',
            'name.min' => 'The organization name must be at least 3 characters long.',
            'name.max' => 'The organization name must not exceed 255 characters.',

            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.min' => 'The email address must be at least 3 characters long.',
            'email.max' => 'The email address must not exceed 55 characters.',

            'phone_number.required' => 'Please enter a phone number.',
            'phone_number.string' => 'The phone number must be a string.',
            'phone_number.min' => 'The phone number must be at least 9 characters long.',
            'phone_number.max' => 'The phone number must not exceed 50 characters.',

            'address.required' => 'Please enter an address.',
            'address.string' => 'The address must be a string.',
            'address.min' => 'The address must be at least 3 characters long.',
            'address.max' => 'The address must not exceed 255 characters.',

            'link_facebook.string' => 'The Facebook link must be a string.',
            'link_facebook.min' => 'The Facebook link must be at least 5 characters long.',
            'link_facebook.max' => 'The Facebook link must not exceed 255 characters.',

            'link_twitter.string' => 'The Twitter link must be a string.',
            'link_twitter.min' => 'The Twitter link must be at least 5 characters long.',
            'link_twitter.max' => 'The Twitter link must not exceed 255 characters.',

            'link_map.string' => 'The map link must be a string.',
            'link_map.min' => 'The map link must be at least 5 characters long.',
            'link_map.max' => 'The map link must not exceed 255 characters.',

            'link_linkedin.string' => 'The LinkedIn link must be a string.',
            'link_linkedin.min' => 'The LinkedIn link must be at least 5 characters long.',
            'link_linkedin.max' => 'The LinkedIn link must not exceed :max characters.',

            'office_hour.string' => 'Office hours must be a string.',
            'office_hour.min' => 'Office hours must be at least 5 characters long.',
            'office_hour.max' => 'Office hours must not exceed 255 characters.',

            'days_of_opening.string' => 'Days of opening must be a string.',
            'days_of_opening.min' => 'Days of opening must be at least 5 characters long.',
            'days_of_opening.max' => 'Days of opening must not exceed 255 characters.',

            'img_logo.mimes' => 'The logo image must be of type: jpg, jpeg, png.',
            'img_logo.max' => 'The logo image must not exceed 512 KB.',

            'img_favicon.mimes' => 'The favicon image must be of type: jpg, jpeg, png.',
            'img_favicon.max' => 'The favicon image must not exceed 512 KB.',
        ];
    }
}
