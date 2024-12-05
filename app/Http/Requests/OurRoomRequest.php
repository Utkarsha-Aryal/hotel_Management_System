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
            'category' => 'required',
            'order'=>'required|numeric|min:1|max_digits:5',
            'maximum_occupancy'=>'required|numeric|min:1|max:30',
            'room_no'=>'required|numeric|min:1',
            'floor_no'=>'required|numeric|min:1',
            'smoking' =>'required|in:Y,N',
            'room_status'=>'required|in:Available,Occupied,Maintenance,Blocked',
            'room_size'=>'required|numeric',
        ];
    }

   public function messages()
{
    return [
        // Category
        'category_id.required' => 'Please select a category.',
        
        // Order
        'order.required' => 'The order number is required.',
        'order.numeric' => 'The order number must be a valid number.',
        'order.min' => 'The order number must be at least 1.',
        'order.max_digits' => 'The order number cannot exceed 5 digits.',

        // Maximum Occupancy
        'maximum_occupancy.required' => 'Please enter the maximum occupancy.',
        'maximum_occupancy.numeric' => 'The maximum occupancy must be a valid number.',
        'maximum_occupancy.min' => 'The occupancy must be at least 1.',
        'maximum_occupancy.max' => 'The occupancy cannot exceed 30.',

        // Room Number
        'room_no.required' => 'The room number is required.',
        'room_no.numeric' => 'The room number must be a valid number.',
        'room_no.min' => 'The room number must be at least 1.',

        // Floor Number
        'floor_no.required' => 'The floor number is required.',
        'floor_no.numeric' => 'The floor number must be a valid number.',
        'floor_no.min' => 'The floor number must be at least 1.',

        // Smoking
        'smoking.required' => 'Please select the smoking preference.',
        'smoking.in' => 'The smoking option must be either "Yes" (Y) or "No" (N).',

        // Room Status
        'room_status.required' => 'Please select the room status.',
        'room_status.in' => 'The room status must be one of: Available, Occupied, Maintenance, Blocked.',

        // Room Size
        'room_size.required' => 'The room size is required.',
        'room_size.numeric' => 'The room size must be a valid number.',
        'room_size.min' => 'The room size must be at least 1.',

    ];
}

}
