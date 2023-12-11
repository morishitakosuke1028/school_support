<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\gradeClassHistory;

class gradeClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_name',
        'class_name',
        'school_id',
    ];

    public function gradeClassHistories()
    {
        return $this->hasOne(GradeClassHistory::class);
    }
}
