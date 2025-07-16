<?php

namespace App\Filament\Resources;

use App\Models\Concern;
use App\Models\Student;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\Resources\ConcernResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ConcernResource extends Resource
{
    protected static ?string $model = Concern::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    protected static ?string $navigationLabel = 'Student Concerns';
    protected static ?string $modelLabel = 'Concern';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category')
                    ->label('Category')
                    ->disabled(),

                Forms\Components\Textarea::make('message')
                    ->label('Student Message')
                    ->disabled(),

                Forms\Components\Textarea::make('admin_response')
                    ->label('Admin Response')
                    ->rows(4)
                    ->nullable(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Resolved' => 'Resolved',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.fullname')
                    ->label('Student'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Pending' => 'warning',
                        'In Progress' => 'info',
                        'Resolved' => 'success',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Limit to student concerns in admin's department
        if (Auth::user()->hasRole('admin')) {
            $query->whereHas('student', function ($q) {
                $q->where('department_id', Auth::user()->department_id);
            });
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConcerns::route('/'),
            'edit' => Pages\EditConcern::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'superadmin']);
    }
}
