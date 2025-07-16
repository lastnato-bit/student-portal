<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concern extends Model
{
    // Explicitly define the table name (optional if it follows Laravel naming convention)
    protected $table = 'concerns';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'student_id',
        'category',
        'message',
        'status',
        'admin_response',
    ];

    /**
     * Get the student who raised the concern.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function getFullnameAttribute()
{
    return "{$this->lastname}, {$this->firstname} {$this->middlename}";
}

}
