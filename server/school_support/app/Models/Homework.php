<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
