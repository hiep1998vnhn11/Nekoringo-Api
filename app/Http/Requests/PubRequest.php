<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PubRequest extends FormRequest
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
            'name' => 'required|unique:pubs,name|min:4|max:200',
            'phone_number' => 'required',
            'description' => 'required',
            'main_email' => 'required|min:5|max:50',
            'image' => 'mimes:jpeg,png|max:10000',
            'address' => 'required|min:5|max:255'
        ];
    }
}
