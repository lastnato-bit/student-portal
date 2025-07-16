<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'course',
        'year_level',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(\App\Models\ClassSchedule::class, 'section_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'section_id');
    }
    // app/Models/Section.php
public function courses()
{
    return $this->belongsToMany(Course::class);
}
public function classSchedules()
{
    return $this->hasMany(ClassSchedule::class);
}

}
