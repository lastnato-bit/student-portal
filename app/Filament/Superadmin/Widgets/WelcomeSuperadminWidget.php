<?php

namespace App\Filament\Superadmin\Widgets;

use Filament\Widgets\Widget;

class WelcomeSuperadminWidget extends Widget
{
    protected static string $view = 'filament.superadmin.widgets.welcome-superadmin';

    protected int | string | array $columnSpan = 'full';
}
