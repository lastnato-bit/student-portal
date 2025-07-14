<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuperadminCreationLog extends Model
{
    /**
     * If you prefer not to use updated_at
     */
    public $timestamps = false;

    /**
     * Mass-assignable columns
     */
    protected $fillable = [
        'created_by',
        'new_superadmin_id',
        'new_superadmin_email',
        'created_at',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Optional: Reference to the user who created the superadmin
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Optional: Reference to the new superadmin user
     */
    public function newSuperadmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'new_superadmin_id');
    }
}
