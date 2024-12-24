<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class RoomAmenitiesRequest extends FormRequest
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
            'wifi' => ['required',
            Rule::in(['Y','N'])],
            'AC'=> ['required',
            Rule::in(['Y','N'])],
            'Mini_Bar' => ['required',
            Rule::in(['Y','N'])],
            'room_tv'=> ['required',
            Rule::in(['Y','N'])],
            'room_hairdeyer'=> ['required',
            Rule::in(['Y','N'])],
            'room_toiletries'=>['required',
            Rule::in(['Y','N'])],
        ];
        return $rules;
    }

    public function messages()
    {
        return[
            'wifi.required' => 'please select Yes or No option for wifi',
            'AC.required' => 'please select Yes or No option for AC',
            'Mini_Bar.required' => 'please select Yes or No option for mini bar',
            'room_tv.required' => 'please select Yes or No option for tv',
            'room_hairdeyer.required' => 'please select Yes or No option for hairdyer',
            'room_toiletries.required' => 'please select Yes or No option for toiletries',
        ];
    }
}
