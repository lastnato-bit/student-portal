<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables\Filters\SelectFilter;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'System Monitoring';
    protected static ?string $navigationLabel = 'Activity Logs';

    public static function form(Form $form): Form
    {
        // Activity log is read-only
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Action')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('description')
                    ->label('Action Type')
                    ->options(
                        Activity::query()
                            ->distinct()
                            ->pluck('description', 'description')
                            ->toArray()
                    ),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ActivityLogResource\Pages\ListActivityLogs::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            // View all logs
            return parent::getEloquentQuery();
        }

        if ($user->hasRole('admin')) {
            // View logs of users within same department
            return parent::getEloquentQuery()
                ->whereHas('causer', function ($query) use ($user) {
                    $query->where('department_id', $user->department_id);
                });
        }

        if ($user->hasRole('student')) {
            // View only their own logs
            return parent::getEloquentQuery()
                ->where('causer_id', $user->id);
        }

        // Default: no access
        return parent::getEloquentQuery()->whereRaw('0 = 1');
    }
}
