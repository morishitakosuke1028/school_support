<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
