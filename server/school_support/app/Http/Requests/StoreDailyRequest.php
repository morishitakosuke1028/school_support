<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyRequest extends FormRequest
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
            'dailies.*.child_id' => ['required', 'integer'],
            'dailies.*.attendance_status' => ['nullable', 'integer'],
            'dailies.*.absence_reason' => ['nullable', 'string'],
            'dailies.*.start_time' => ['nullable', 'date_format:Y-m-d H:i'],
            'dailies.*.end_time' => ['nullable', 'date_format:Y-m-d H:i'],
            'dailies.*.admin_memo' => ['nullable', 'string'],
            'dailies.*.parent_memo' => ['nullable', 'string'],
        ];
    }
}
