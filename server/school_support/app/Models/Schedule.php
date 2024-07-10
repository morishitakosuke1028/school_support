<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_class_id',
        'subject_id_first',
        'subject_id_second',
        'subject_id_third',
        'subject_id_fourth',
        'subject_id_five',
        'subject_id_six',
        'subject_id_other',
        'subject_id_all_check',
        'schedule_date',
    ];

    public static function bulkStore(array $scheduleEntries)
    {
        foreach ($scheduleEntries as $date => $data) {
            $data['schedule_date'] = $date;

            if (isset($data['subject_id_other']) && is_array($data['subject_id_other'])) {
                if (empty($data['subject_id_other'][0])) {
                    $data['subject_id_other'] = null;
                } else {
                    $data['subject_id_other'] = $data['subject_id_other'][0];
                }
            }

            $schedule = self::updateOrCreate(
                ['schedule_date' => $date, 'grade_class_id' => $data['grade_class_id']],
                $data
            );
        }
    }

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }
}
