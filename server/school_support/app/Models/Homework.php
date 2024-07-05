<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Homework extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_class_id',
        'homework_day',
        'reading',
        'language_drill',
        'arithmetic',
        'diary',
        'ipad',
        'other',
    ];

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }

    public static function bulkStore(array $homeworkEntries)
    {
        foreach ($homeworkEntries as $date => $data) {
            $data['homework_day'] = $date;

            self::updateOrCreate(
                ['homework_day' => $date, 'grade_class_id' => $data['grade_class_id']],
                $data
            );
        }
    }
}
