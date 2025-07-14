<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ActivityLog;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ActivityLogs extends Widget
{
    protected static string $view = 'filament.admin.widgets.activity-logs';
    protected static ?int $sort = 2;

    public $logs = [];

    public function mount(): void
    {
        $this->logs = $this->getActivityLogs();
    }

    protected function getActivityLogs()
    {
        $user = Auth::user();

        // Superadmin: see all logs
        if ($user->hasRole('superadmin')) {
            return ActivityLog::latest()->take(50)->get();
        }

        // Admin: see only logs related to students in their department
        if ($user->hasRole('admin')) {
            return ActivityLog::whereHas('causer.student', function ($query) use ($user) {
                $query->where('department_id', $user->department_id);
            })->latest()->take(50)->get();
        }

        // Others: no logs
        return collect();
    }

    public static function canView(): bool
    {
        return Auth::user()?->hasAnyRole(['admin', 'superadmin']);
    }
}
