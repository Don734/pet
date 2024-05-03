<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'type' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле Имя обязательно для заполнения.',
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.email' => 'Некорректный формат Email.',
            'email.unique' => 'Такой Email уже существует.',
            'password.required' => 'Поле Пароль обязательно для заполнения.',
            'password.min' => 'Минимальная длина пароля :min символов.',
            'password.confirmed' => 'Пароль и подтверждение пароля не совпадают.',
        ];
    }
}
