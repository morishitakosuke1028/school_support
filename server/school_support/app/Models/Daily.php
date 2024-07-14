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

    public static function createOrUpdateDaily(array $dailyData)
    {
        if (isset($dailyData['id']) && $daily = self::find($dailyData['id'])) {
            $daily->update([
                'child_id' => $dailyData['child_id'],
                'attendance_status' => $dailyData['attendance_status'],
                'absence_reason' => $dailyData['absence_reason'],
                'start_time' => $dailyData['start_time'],
                'end_time' => $dailyData['end_time'],
                'admin_memo' => $dailyData['admin_memo'],
                'parent_memo' => $dailyData['parent_memo'],
                'date_use' => $dailyData['date_use'],
                'update_method' => $dailyData['update_method']
            ]);
        } else {
            self::create([
                'child_id' => $dailyData['child_id'],
                'attendance_status' => $dailyData['attendance_status'],
                'absence_reason' => $dailyData['absence_reason'],
                'start_time' => $dailyData['start_time'],
                'end_time' => $dailyData['end_time'],
                'admin_memo' => $dailyData['admin_memo'],
                'parent_memo' => $dailyData['parent_memo'],
                'date_use' => $dailyData['date_use'],
                'entry_method' => $dailyData['entry_method'],
            ]);
        }
    }

    public static function processDailies(array $dailies)
    {
        foreach ($dailies as $dailyData) {
            self::createOrUpdateDaily($dailyData);
        }
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
