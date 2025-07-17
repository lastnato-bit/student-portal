<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Activity extends SpatieActivity
{
    // Optional: custom relationship to user
   
}
