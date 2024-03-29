<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\GradeClassHistory;

class Child extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kana',
        'email',
        'zip',
        'address',
        'tel',
        'gender',
        'admission_date',
        'movein_date',
        'graduation_date',
        'birthday',
        'pin_code',
        'session_id',
        'school_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gradeClassHistories()
    {
        return $this->hasMany(GradeClassHistory::class);
    }

    public function gradeClass()
    {
        return $this->belongsToMany(GradeClass::class, 'grade_class_histories', 'child_id', 'grade_class_id');
    }

    public function dailies()
    {
        return $this->hasMany(Daily::class);
    }

    public function growths()
    {
        return $this->hasMany(Growth::class);
    }
}
