<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AuditLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Activity Logs';
    protected static ?string $navigationGroup = 'Logs';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Action')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('causer.full_name')
                    ->label('Performed By')
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {
                        $user = $record->causer;
                        if ($user) {
                            return trim("{$user->firstname} {$user->middlename} {$user->lastname}");
                        }
                        return '-';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\AuditLogResource\Pages\ListAuditLogs::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // ✅ Ensure 'causer' is eager loaded
        $query = static::getModel()::query()
            ->with('causer')
            ->latest();

        $user = Auth::user();

        // ✅ Filter by department if admin
        if ($user->hasRole('admin')) {
            $query->whereHas('causer', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            });
        }

        // ✅ Enable search by action or causer name
        if (request()->has('tableSearch') && $search = request('tableSearch')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('causer', function ($causerQuery) use ($search) {
                      $causerQuery->where('firstname', 'like', "%{$search}%")
                                  ->orWhere('middlename', 'like', "%{$search}%")
                                  ->orWhere('lastname', 'like', "%{$search}%");
                  });
            });
        }

        return $query;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->hasRole('admin');
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()?->hasRole('admin');
    }
}
