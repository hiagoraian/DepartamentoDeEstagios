<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSchool extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'city_id',
        'school_name',
        'students_impacted',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
