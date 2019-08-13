<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRegisterRequest extends FormRequest
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
            'verification_code' => 'required',
            'name' => ['required', 'string', 'max:20','unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];

    }
}
