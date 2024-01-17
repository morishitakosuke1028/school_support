<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildDailyRequest extends FormRequest
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
            'child_id' => ['required', 'integer'],
            'attendance_status' => ['nullable', 'integer'],
            'absence_reason' => ['nullable', 'string'],
            'start_time' => ['nullable', 'date_format:Y-m-d H:i'],
            'end_time' => ['nullable', 'date_format:Y-m-d H:i'],
            'parent_memo' => ['nullable', 'string'],
            'date_use' => ['nullable', 'date_format:Y-m-d'],
            'entry_method' => ['nullable', 'string'],
            'update_method' => ['nullable', 'string'],
        ];
    }
}
