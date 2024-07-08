<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public static function createSubject(array $attributes)
    {
        return self::create($attributes);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
