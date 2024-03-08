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

    public function child()
    {
        return $this->belongsToMany(Child::class, 'grade_class_histories', 'grade_class_id', 'child_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gradeClassHistories()
    {
        return $this->hasMany(GradeClassHistory::class);
    }
}
