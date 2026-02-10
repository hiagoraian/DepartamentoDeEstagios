<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'uf',
        'ibge_code',
    ];

    public function reportSchools()
    {
        return $this->hasMany(ReportSchool::class);
    }
}
