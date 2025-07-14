<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    // Define the table fields that can be mass-assigned
    protected $fillable = [
        'slug',     // Identifier (e.g. "enrollment_notification")
        'subject',  // Email subject
        'body',     // Email content/body with variables like {{ $user->name }}
    ];
}
