<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoregradeClassRequest extends FormRequest
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
            'school_id' => ['required'],
            'grade_name' => ['required', 'max:50'],
            'class_name' => ['required', 'max:50'],
        ];
    }
}
