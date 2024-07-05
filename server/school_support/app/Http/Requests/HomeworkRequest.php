<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeworkRequest extends FormRequest
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
            'homeworkData.*.grade_class_id' => 'required|integer',
            'homeworkData.*.homework_day' => 'required|date',
            'homeworkData.*.reading' => 'nullable|string',
            'homeworkData.*.language_drill' => 'nullable|string',
            'homeworkData.*.arithmetic' => 'nullable|string',
            'homeworkData.*.diary' => 'nullable|string',
            'homeworkData.*.ipad' => 'nullable|string|max:50',
            'homeworkData.*.other' => 'nullable|string|max:50',
        ];
    }
}
