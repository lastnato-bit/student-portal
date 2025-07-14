<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class WelcomeAdminWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.welcome-admin';

    protected int | string | array $columnSpan = 'full';
}
