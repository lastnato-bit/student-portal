<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use App\Models\Student;
use App\Models\Grade;
use App\Models\ClassSchedule;
use Spatie\Permission\Models\Role;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuperadminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        return [
            Stat::make('👨‍🎓 Total Students', Student::count())
                ->description('All registered students')
                ->color('success'),

            Stat::make('🧑‍💼 Total Admins', User::role('admin')->count())
                ->description('All active admins')
                ->color('info'),

            Stat::make('🏛️ Departments', Department::count())
                ->description('Configured departments')
                ->color('warning'),

            Stat::make('🎓 Subjects', ClassSchedule::count())
                ->description('All created subjects / classes')
                ->color('purple'),

            Stat::make('📝 Grades Submitted', Grade::count())
                ->description('Total grades encoded')
                ->color('gray'),

            Stat::make('🆕 New Users This Month', User::where('created_at', '>=', $startOfMonth)->count())
                ->description('Users registered in ' . $startOfMonth->format('F'))
                ->color('success'),

            Stat::make('🛡️ User Roles', Role::count())
                ->description('Total available roles')
                ->color('gray'),

            // Optional: only if you log login activity
            Stat::make('🔐 Logins Today', 0) // replace 0 with real count if tracked
                ->description('Tracked via activity log or login events')
                ->color('info'),
        ];
    }
}
