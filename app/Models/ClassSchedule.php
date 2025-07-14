<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ClassSchedule extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'department_id',
        'section_id',
        'course_id',
        'subject_id',         // ✅ Replaces 'subject'
        'units',
        'instructor_id',
        'day',
        'start_time',
        'end_time',
        'room',
        'semester',
        'school_year',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function instructor()
{
    return $this->belongsTo(Instructor::class);
}


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'department_id',
                'section_id',
                'course_id',
                'subject_id',
                'units',
                'instructor_id',
                'day',
                'start_time',
                'end_time',
                'room',
                'semester',
                'school_year',
            ])
            ->logOnlyDirty()
            ->useLogName('class_schedule');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Class schedule record has been {$eventName}";
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function department()
{
    return $this->belongsTo(Department::class);
}

    public function subject()
{
    return $this->belongsTo(Subject::class);
}



// App\Models\ClassSchedule.php




}
