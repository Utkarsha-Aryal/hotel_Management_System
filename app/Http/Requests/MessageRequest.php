<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
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
        $post = filterData($request->all());
        $rules = [
            'message_by' => 'required',
            'designation' => 'required',
            'order_number' => 'required|numeric|min:1|max_digits:5',
            'message' => 'required'
            
        ];

        if ($post['id'] == null) {
            $rules['image'] = 'nullable|mimes:jpg,jpeg,png|max:512';
        } else {
            $rules['image'] = 'nullable|mimes:jpg,jpeg,png|max:512';
        }
        return $rules;
    }
    public function messages(): array
    {
        return [

            //message for message by field 
            'message_by' => 'This field is required.',

            //message for designation field
            'designation' => 'This field is required.',

            /* Message for 'order_number' field*/
            'order_number.required' => 'Please enter order number.',
            'order_number.max_digits' => 'Order must be of 5 digits.',
            'order_number.numeric' => 'Order must be a number.',
            'order_number.min' => 'Order must be 1 or greater.',

            //message for image field 
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'The image size should not greater than :max KB.',

            // message 
            'message.required' => 'It is required to fill in the message field'
        ];
    }
}