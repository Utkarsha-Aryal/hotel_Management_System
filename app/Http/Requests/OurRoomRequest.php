<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OurRoomRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'order_number'=>'required|numeric|min:1|max_digits:5',
            'occupancy'=>'required|numeric|min:1|max:30',
            'room_no'=>'required|numeric|min:1',
            'wifi'=>'required|in:Y,N',
            'AC' =>'required|in:Y,N',
            'TV'=>'required|in:Y,N',
            'minibar'=>'required|in:Y,N',
            'room_service'=>'required|in:Y,N',
            "private_bathroom"=>'required|in:Y,N',
            "balcony"=>'required|in:Y,N',
            'details'=> 'required|min:5|max:1000',
            

        ];
    }

    public function messages()
    {
            return [
                'title.required' => 'The title is required.',
                'title.min' => 'The title must be at least 3 characters.',
                'title.max' => 'The title may not be greater than 255 characters.',

                'occupancy.required'=>'Please enter how many people can fit in the room',
                'occupancy.min'=>'The occupancy must be at least 1',
                'occupancy.max'=>'The maximum occupancy is 30',
                
                'order_number.required' => 'The order number is required.',
                'order_number.numeric' => 'The order number must be a valid number.',
                'order_number.min' => 'The order number must be at least 1.',
                'order_number.max' => 'The order number cannot exceed 6 digits.',
                
                'occupancy.required' => 'The occupancy is required.',
                'occupancy.numeric' => 'The occupancy must be a valid number.',
                
                'room_no.required' => 'The room number is required.',
                'room_no.numeric' => 'The room number must be a valid number.',
                'room_no.min' => 'The room number must be at least 1.',
                
                'wifi.required' => 'Please select whether the room has wifi.',
                'wifi.in' => 'The wifi option must be either "Y" or "N".',
                
                'AC.required' => 'Please select whether the room has AC.',
                'AC.in' => 'The AC option must be either "Y" or "N".',
                
                'TV.required' => 'Please select whether the room has a TV.',
                'TV.in' => 'The TV option must be either "Y" or "N".',
                
                'minibar.required' => 'Please select whether the room has a minibar.',
                'minibar.in' => 'The minibar option must be either "Y" or "N".',
                
                'room_service.required' => 'Please select whether the room has room service.',
                'room_service.in' => 'The room service option must be either "Y" or "N".',
                
                'private_bathroom.required' => 'Please select whether the room has a private bathroom.',
                'private_bathroom.in' => 'The private bathroom option must be either "Y" or "N".',
                
                'balcony.required' => 'Please select whether the room has a balcony.',
                'balcony.in' => 'The balcony option must be either "Y" or "N".',
                
                'details.required' => 'The details field is required.',
                'details.min' => 'The details must be at least 5 characters.',
                'details.max' => 'The details may not be greater than 1000 characters.',
            ];

        
    }
}
