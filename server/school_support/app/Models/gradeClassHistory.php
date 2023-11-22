<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Child;
use App\Models\gradeClass;

class gradeClassHistory extends Model
{
    protected $casts = [
        'child_id' => 'array',
    ];

    use HasFactory;

    protected $fillable = [
        'user_id',
        'child_id',
        'grade_class_id',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class);
    }
}
