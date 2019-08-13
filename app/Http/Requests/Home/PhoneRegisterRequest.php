<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRegisterRequest extends FormRequest
{


    protected $redirect = 'registersteptwo';
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
            'verification_code' => 'required|min:4|max:4',
            'name'              => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users',
            'password'          => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'verification_code' => '验证码不正确',
            'name.regex'        => '用户名只支持英文、数字、横杠和下划线。',
            'name.between'      => '用户名必须介于 3 - 25 个字符之间。',
            'name.required'     => '用户名不能为空。',
            'password.min'      => '密码最少8个字符',
            'password.confirmed'=> '两次密码输入不一致',
        ];
    }

}
