<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ScheduleRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $scheduleData = $this->input('scheduleData', []);
        $transformedData = [];

        foreach ($scheduleData as $date => $data) {
            $data['schedule_date'] = $date;

            if (isset($data['subject_id_other']) && is_array($data['subject_id_other'])) {
                if (empty($data['subject_id_other'][0])) {
                    $data['subject_id_other'] = null;
                } else {
                    $data['subject_id_other'] = $data['subject_id_other'][0];
                }
            }

            $transformedData[$date] = $data;
        }

        $this->merge(['scheduleData' => $transformedData]);
    }

    public function rules()
    {
        return [
            'scheduleData' => 'required|array',
            'scheduleData.*.grade_class_id' => 'required|integer',
            'scheduleData.*.schedule_date' => 'required|date',
            'scheduleData.*.subject_id_first' => 'nullable|integer',
            'scheduleData.*.subject_id_second' => 'nullable|integer',
            'scheduleData.*.subject_id_third' => 'nullable|integer',
            'scheduleData.*.subject_id_fourth' => 'nullable|integer',
            'scheduleData.*.subject_id_five' => 'nullable|integer',
            'scheduleData.*.subject_id_six' => 'nullable|integer',
            'scheduleData.*.subject_id_other' => 'nullable|string',
            'scheduleData.*.subject_id_all_check' => 'nullable|integer',
        ];
    }
}
