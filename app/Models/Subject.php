<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subject extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'course_id',
        'code',
        'name',
        'description',
        'units',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function classSchedules()
{
    return $this->hasMany(ClassSchedule::class);
}

}