<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\User;
use App\Models\ClassSchedule;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, LogsActivity,SoftDeletes;

    protected $table = 'grades';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'student_id',
        'class_schedule_id',
        'semester',
        'school_year',
        'grade',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('grade')
            ->logOnly([
                'student_id',
                'class_schedule_id',
                'semester',
                'school_year',
                'grade',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => "Grade record was {$eventName}");
    }

    /**
     * The student this grade belongs to.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * The class schedule this grade is associated with.
     */
    public function classSchedule()
    {
        return $this->belongsTo(ClassSchedule::class, 'class_schedule_id');
    }

    /**
     * Access the instructor through the class schedule.
     */
    public function instructor()
    {
        return $this->hasOneThrough(
            User::class,
            ClassSchedule::class,
            'id',                // ClassSchedule id
            'id',                // User id
            'class_schedule_id', // Foreign key on Grade
            'instructor_id'      // Foreign key on ClassSchedule
        );
    }
    public function subject()
{
    return $this->belongsTo(Subject::class);
}

}