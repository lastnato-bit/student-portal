<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructorResource\Pages;
use App\Models\Instructor;
use App\Models\Department;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class InstructorResource extends Resource
{
    protected static ?string $model = Instructor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Academic Management';

    public static function form(Form $form): Form
    {
        $user = Auth::user();

        return $form->schema([
            TextInput::make('lastname')->required()->maxLength(255),
            TextInput::make('firstname')->required()->maxLength(255),
            TextInput::make('middlename')->nullable()->maxLength(255),
            TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            TextInput::make('contact_number')->nullable()->maxLength(20),

            Select::make('department_id')
                ->label('Department')
                ->required()
                ->options(function () use ($user) {
                    if ($user->hasRole('superadmin')) {
                        return Department::pluck('name', 'id');
                    }

                    return Department::where('id', $user->department_id)->pluck('name', 'id');
                })
                ->default($user->department_id)
                ->disabled($user->hasRole('admin')), // readonly for admin
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->label('Name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('contact_number')->label('Contact')->sortable(),
                TextColumn::make('department.name')->label('Department')->sortable()->searchable(),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstructors::route('/'),
            'create' => Pages\CreateInstructor::route('/create'),
            'edit' => Pages\EditInstructor::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasRole('superadmin') || Auth::user()?->hasRole('admin');
    }
}
