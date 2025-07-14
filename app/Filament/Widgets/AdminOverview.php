<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Section;
use App\Models\User;

class AdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::count())
                ->description('All students in your department')
                ->color('success'),

            Stat::make('Assigned Grades', Grade::count())
                ->description('Grades entered by department')
                ->color('info'),

            //Stat::make('Pending Grades', Grade::where('status', 'pending')->count())
                //->description('Grades needing review')
                //->color('danger'),

            Stat::make('Sections', Section::count())
                ->description('Total class sections')
                ->color('warning'),

            Stat::make('Admins', User::role('admin')->count())
                ->description('Active admin accounts')
                ->color('primary'),
        ];
    }
}
