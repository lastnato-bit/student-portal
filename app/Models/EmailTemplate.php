<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    // Define the table fields that can be mass-assigned
    protected $fillable = [
        'slug',     // Identifier (e.g. "enrollment_notification")
        'subject',  // Email subject
        'body',     // Email content/body with variables like {{ $user->name }}
    ];
}
