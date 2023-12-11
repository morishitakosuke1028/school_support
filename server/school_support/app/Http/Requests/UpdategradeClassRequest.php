<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdategradeClassRequest extends FormRequest
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
            'grade_name' => ['required', 'string', 'max:255'],
            'class_name' => ['required', 'string', 'max:255'],
        ];
    }
}
