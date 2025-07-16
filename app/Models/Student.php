<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Student extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    

    protected $fillable = [
        'student_number',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'department_id',
        'section_id',
        'gender',
        'birthdate',
        'contact_number',
        'address',
        'course_id',
        'year_level',
        'status',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Spatie activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'firstname', 'middlename', 'lastname',
                'email', 'student_number', 'section_id',
                'department_id','course_id', 'user_id', 'status'
            ])
            ->useLogName('student')
            ->logOnlyDirty();
    }

    // Relationships

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}


    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function course()
{
    return $this->belongsTo(Course::class);
}


    public function classSchedules()
{
    return $this->belongsToMany(ClassSchedule::class);
}

    // Accessor for full name
    public function getFullNameAttribute(): string
    {
        return collect([
            $this->firstname,
            $this->middlename,
            $this->lastname
        ])->filter()->implode(' ');
    }

    /**
     * Automatically delete the linked user if student is deleted
     */
   


}
