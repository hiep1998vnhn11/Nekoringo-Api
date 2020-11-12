<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePubRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'min:1|max:500|string',
            'main_email' => 'email|min:5|max:55',
            'phone_number' => 'min:8|max:12',
            'address' => 'min:1|max:120',
            'name' => 'min:3|max:60',
            'business_time' => 'min:4|max:40',
            'video_path' => 'min:1',
            'map_path' => 'min:1',
            'image' => 'mimes:jpeg,png|max:10000'
        ];
    }
}
