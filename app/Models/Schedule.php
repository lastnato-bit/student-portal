<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
    'section_id',
    'subject',
    'units',
    'instructor',
    'day',
    'start_time',
    'end_time',
    'room',
    'semester',
    'school_year',
];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function subject()
{
    return $this->belongsTo(Subject::class);
}
}

