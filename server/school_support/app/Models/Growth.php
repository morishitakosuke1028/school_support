<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'height',
        'weight',
        'chest',
        'abdomen',
        'head',
        'measurement_month',
    ];

    public static function createGrowth(array $attributes)
    {
        return self::create($attributes);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
