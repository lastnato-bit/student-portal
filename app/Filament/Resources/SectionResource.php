<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Models\Section;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

use App\Models\Course;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Academic Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Section Name')
                ->required()
                ->unique(ignoreRecord: true),

            // 👇 Automatically assign department for admin, allow selection for superadmin
            Auth::user()?->hasRole('superadmin')
                ? Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->required()
                : Hidden::make('department_id')
                    ->default(Auth::user()?->department_id)
                    ->required(),


            Select::make('courses')
    ->label('Courses')
    ->relationship('courses', 'name')
    ->multiple()
    ->preload()
    ->required(),

            Select::make('year_level')
                ->label('Year Level')
                ->options([
                    '1st Year' => '1st Year',
                    '2nd Year' => '2nd Year',
                    '3rd Year' => '3rd Year',
                    '4th Year' => '4th Year',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Section Name')->searchable()->sortable(),
                TextColumn::make('department.name')->label('Department')->sortable(),
                TextColumn::make('year_level')->label('Year Level')->sortable(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query();

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return $query->where('department_id', $user->department_id);
        }

        return $query;
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasRole('admin') || Auth::user()?->hasRole('superadmin');
    }
}
