<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HandbookRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'coord_x' => 'nullable|string|max:50',
            'coord_y' => 'nullable|string|max:50',
            'working_hours' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
