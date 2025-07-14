<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'System Settings';

    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('superadmin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Key')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('value')
                    ->label('Value')
                    ->nullable(),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('data.school_year')
                            ->label('Current School Year')
                            ->nullable(),

                        Forms\Components\Select::make('data.semester')
                            ->label('Semester')
                            ->options([
                                '1st' => '1st Semester',
                                '2nd' => '2nd Semester',
                                'summer' => 'Summer',
                            ])
                            ->nullable(),

                        Forms\Components\Toggle::make('data.maintenance_mode')
                            ->label('Enable Maintenance Mode'),

                        Forms\Components\Textarea::make('data.announcement')
                            ->label('Announcement Banner')
                            ->rows(2)
                            ->nullable(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->label('Key'),
                Tables\Columns\TextColumn::make('data.school_year')->label('School Year'),
                Tables\Columns\TextColumn::make('data.semester')->label('Semester'),
                Tables\Columns\IconColumn::make('data.maintenance_mode')
                    ->label('Maintenance')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
{
    return auth()->user()?->hasRole('superadmin');
}
}
