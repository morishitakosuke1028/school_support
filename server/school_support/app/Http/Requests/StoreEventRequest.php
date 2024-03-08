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
            'start_datetime' => ['required'],
            'end_datetime' => ['required'],
            'title' => ['required', 'string'],
            'place' => ['required', 'string'],
            'personal_effect' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];
    }
}
