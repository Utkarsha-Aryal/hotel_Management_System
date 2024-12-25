<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoomPriceRequest extends FormRequest
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
        $rules = [
            'category_id' => 'required|exists:room_categories,id', // Ensures the category exists in the database
            'season_id' => 'required|exists:seasons,id', // Ensures the season exists in the database
            'price' => 'required|numeric|min:0', // Allows only non-negative numbers for price
            'order' => 'required|integer|min:1|max:5', // Ensures the order is an integer and within the range
        ];
        return $rules;
    } 

    public function messages(){
        return [
            'category_id.required' =>'Please select the category',
            'season_id.required' => "Please select the Season",
            'price.required'=>'The price field is required',
            'order.required'=>'The order field is required'
        ];
    }
}
