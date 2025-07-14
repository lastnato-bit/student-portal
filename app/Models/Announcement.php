<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'published_at', // optional for scheduling
        'user_id',       // optional for tracking the creator
    ];

    protected $dates = [
        'published_at',
        'deleted_at',
    ];

    /**
     * Optional: Associate announcements with a user (admin/superadmin)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Optional: Scope to only published announcements
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
