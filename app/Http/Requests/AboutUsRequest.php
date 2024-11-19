<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
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
        $rules =  [
            'introduction' => 'required|string|min:5|max:1024',
            'founder_name' => 'required|string|min:5|max:255',
            'founder_message' => 'required|string|min:5|max:1024',
            'img_introduction' => 'nullable|mimes:jpg,jpeg,png|max:512',
            'founder_image' => 'nullable|mimes:jpg,jpeg,png|max:512',
            'vision' => 'nullable|string|min:1|max:255',
            'mission' => 'nullable|string|min:1|max:255',
            'vision_image' => 'nullable|mimes:jpg,jpeg,png|max:512',
            'mission_image' => 'nullable|mimes:jpg,jpeg,png|max:512',
            'video_title' => 'nullable|string|min:1|max:255',
            'video_url' => 'nullable|url|max:255',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            // Introduction
            'introduction.required' => 'Please enter the introduction.',
            'introduction.string' => 'The introduction must be a string.',
            'introduction.min' => 'The introduction must be at least 5 characters long.',
            'introduction.max' => 'The introduction must not exceed 1024 characters.',

            // Founder Name
            'founder_name.required' => 'Please enter the founder\'s name.',
            'founder_name.string' => 'The founder\'s name must be a string.',
            'founder_name.min' => 'The founder\'s name must be at least 5 characters long.',
            'founder_name.max' => 'The founder\'s name must not exceed 255 characters.',

            // Founder Message
            'founder_message.required' => 'Please enter the founder\'s message.',
            'founder_message.string' => 'The founder\'s message must be a string.',
            'founder_message.min' => 'The founder\'s message must be at least 5 characters long.',
            'founder_message.max' => 'The founder\'s message must not exceed :max characters.',

            // Image Introduction
            'img_introduction.mimes' => 'The introduction image must be a file of type: jpg, jpeg, png.',
            'img_introduction.max' => 'The introduction image must not exceed 512 KB.',

            // Founder Image
            'founder_image.mimes' => 'The founder image must be a file of type: jpg, jpeg, png.',
            'founder_image.max' => 'The founder image must not exceed 512 KB.',

            // Landing Image
            'landing_image.mimes' => 'The landing image must be a file of type: jpg, jpeg, png.',
            'landing_image.max' => 'The landing image must not exceed 512 KB.',
            
            // Vision 
            'vision.string' => 'The vision must be a string.',
            'vision.max' => 'The vision must not exceed :max characters.',

            // Mission 
            'mission.string' => 'The mission  must be a string.',
            'mission.max' => 'The mission  must not exceed :max characters.',

            //Vision Image
            'vision_image.mimes' => 'The vision image must be a file of type: jpg, jpeg, png.',
            'vision_image.max' => 'The vision image must not exceed :max KB.',

            //Mission Image
            'misson_image.mimes' => 'The mission image must be a file of type: jpg, jpeg, png.',
            'misson_image.max' => 'The mission im must not exceed :max KB.',

            // 
            'video_title.string' => 'The video title must be a string.',
            'video_title.max' => 'The video title must not exceed :max characters.',

            //Messages for Video URL
            'video_url.url' => 'Please enter a valid Video URL.',
            'video_url.max' => 'The video URL must be samller than 255 characters.',

        ];
    }
}