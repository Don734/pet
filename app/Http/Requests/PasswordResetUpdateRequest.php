<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class PasswordResetUpdateRequest extends FormRequest
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
            'email' => 'required|email|exists:clients',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Поле почта обязательно для заполнения.',
            'email.exists' => 'Такого пользователя не существует.',
            'password.required' => 'Поле пароль обязательно для заполнения.',
            'password.min' => 'Минимальная длина пароля :min символов.',
            'password.confirmed' => 'Пароль и подтверждение пароля не совпадают'
        ];
    }
}
