<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReviewRequest extends FormRequest
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
            'reviewable_type' => 'required',
            'reviewable_id' => 'required|numeric',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string',
            'name' => $this->user() ? 'nullable' : 'string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Пожалуйста, укажите ваше имя.',
        ];
    }
}
