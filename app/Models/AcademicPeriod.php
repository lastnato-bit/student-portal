<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    protected $fillable = ['school_year', 'semester', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
