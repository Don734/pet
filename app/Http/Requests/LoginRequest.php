<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.email' => 'Некорректный формат Email.',
            'password.required' => 'Поле Пароль обязательно для заполнения.',
            'password.min' => 'Минимальная длина пароля :min символов.',
        ];
    }
}
