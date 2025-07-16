<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
   use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'email',
        'contact_number',
        'department_id',
    ];

    /**
     * Get the full name as "Lastname, Firstname Middlename"
     */
    public function getFullNameAttribute(): string
    {
        return $this->lastname . ', ' . $this->firstname . ' ' . $this->middlename;
    }

    /**
     * Instructor belongs to a department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Optionally, relationship to class schedules if needed later
     */
    public function classSchedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }
    

}
