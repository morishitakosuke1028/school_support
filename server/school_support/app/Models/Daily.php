<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Child;

class Daily extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'attendance_status',
        'absence_reason',
        'start_time',
        'end_time',
        'admin_memo',
        'parent_memo',
        'date_use',
        'entry_method',
        'update_method',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
