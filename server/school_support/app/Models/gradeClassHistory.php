<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Child;
use App\Models\gradeClass;

class gradeClassHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'child_id',
        'grade_class_id',
    ];

    public static function updateGradeClassHistory($userId, $gradeClassId, array $childIds)
    {
        $nullRecords = self::where('grade_class_id', $gradeClassId)
            ->whereNull('child_id')
            ->whereNull('user_id')
            ->first();

        if ($nullRecords) {
            $childIdToUpdate = array_shift($childIds);
            $nullRecords->update([
                'user_id' => $userId,
                'child_id' => $childIdToUpdate,
            ]);
        }

        foreach ($childIds as $childId) {
            if (Child::where('id', $childId)->exists()) {
                self::updateOrCreate(
                    [
                        'child_id' => $childId,
                        'grade_class_id' => $gradeClassId,
                    ],
                    [
                        'user_id' => $userId,
                    ]
                );
            }
        }
    }

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gradeClass()
    {
        return $this->belongsTo(GradeClass::class, 'grade_class_id');
    }
}
