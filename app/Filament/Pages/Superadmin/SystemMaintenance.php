<?php

namespace App\Filament\Pages\Superadmin;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth; // ✅ Add this

class SystemMaintenance extends Page
{
    protected static string $view = 'filament.pages.superadmin.system-maintenance';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'maintenance_mode' => Setting::getValue('maintenance_mode') === 'true',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('maintenance_mode')
                    ->label('Enable Maintenance Mode')
                    ->helperText('When enabled, the system will enter maintenance mode.'),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        Setting::setValue(
            'maintenance_mode',
            $this->data['maintenance_mode'] ? 'true' : 'false'
        );

        Notification::make()
            ->title('System setting updated')
            ->body('Maintenance mode has been ' . ($this->data['maintenance_mode'] ? 'enabled.' : 'disabled.'))
            ->success()
            ->send();
    }

    // ✅ Add this method:
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->hasRole('superadmin');
    }
}
