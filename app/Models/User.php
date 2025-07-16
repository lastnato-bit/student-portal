<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use LogsActivity;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
    'lastname',
    'firstname',
    'middlename',
    'email',
    'password',
    'department_id',
    'otp_code',           // ✅ add this
    'otp_expires_at',     // ✅ and this
    'is_verified',        // ✅ and this too
];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'profile_photo_url',
        'full_name',
    ];

    /**
     * Spatie Activity Log configuration.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user')
            ->logOnly(['firstname', 'middlename', 'lastname', 'email', 'department_id'])
            ->logOnlyDirty();
    }

    /**
     * Relationship: User belongs to a department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relationship: User has one linked student (if applicable).
     */
    public function student()
{
    return $this->hasOne(\App\Models\Student::class);
}


    /**
     * Relationship: User has many grades (if student).
     */
    public function grades()
    {
        return $this->hasMany(\App\Models\Grade::class, 'student_id');
    }

    /**
     * Relationship: Activity logs by this user.
     */
    public function activitylog()
    {
        return $this->hasMany(\Spatie\Activitylog\Models\Activity::class, 'causer_id');
    }

    /**
     * Accessor: Get full name of the user.
     */
    public function getFullNameAttribute(): string
    {
        return collect([
            $this->lastname,
            $this->firstname,
            $this->middlename,
        ])->filter()->implode(', ');
    }

    /**
     * Optional: Fallback name attribute if used elsewhere.
     */
    public function getNameAttribute(): string
    {
        return trim("{$this->firstname} {$this->middlename} {$this->lastname}") ?: 'Unnamed User';
    }
    
public function classSchedules()
{
    // Get student record (has section_id), then get schedules for that section
    return $this->hasOne(Student::class, 'user_id')->with('section.classSchedules');
}






}
