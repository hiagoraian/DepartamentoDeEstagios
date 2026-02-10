<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semester',
        'institution',
        'place',
        'course',
        'presentation',
        'activities_description',
        'teaching_assignments',
        'didactic_assignments',
        'positive_aspects',
        'negative_aspects',
        'improvement_suggestions',
        'enade',
        'conclusion',
        'semester_productions',
        'teaching_plan_path',
        'visit_term_path',
        'status',
        'edit_unlocked',
    ];

    protected $casts = [
        'semester_productions' => 'array',
        'edit_unlocked' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schools()
    {
        return $this->hasMany(ReportSchool::class);
    }
}
