<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'grade_class_id' => ['required', 'integer'],
            'start_datetime' => ['nullable', 'date_format:Y-m-d H:i'],
            'end_datetime' => ['nullable', 'date_format:Y-m-d H:i'],
            'title' => ['nullable', 'string'],
            'place' => ['nullable', 'string'],
            'personal_effect' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
        ];
    }
}
