<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterTeacher extends Model
{
    protected $table = 'semester_teacher';

    protected $fillable = [
        'user_id',
        'semester',
        'is_enabled',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}