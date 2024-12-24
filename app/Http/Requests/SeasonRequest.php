<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SeasonRequest extends FormRequest
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
            'Season_Name'=> 'required|string|min:3|max:255',
            'order'=>'required|numeric|max:5',
            'start_date'=>'required|date',
            'end_date'=>'required|date'

        ];
     return $rules;
    }

    public function messages()
    {
        return[
            'Season_Name.required' =>'Please enter the season name',
            'order.required'=>'Please enter the order number',
            'start_date.required'=>'Please enter when the season will start',
            'end_date'=>'Please enter when the season will end'
        ];

    }
}
