<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Child;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'child_id',
        'sender',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
