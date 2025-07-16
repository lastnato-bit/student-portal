<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicPeriod extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['school_year', 'semester', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
