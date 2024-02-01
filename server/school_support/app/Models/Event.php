<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_class_id',
        'start_datetime',
        'end_datetime',
        'title',
        'place',
        'personal_effect',
        'content',
    ];

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }
}
