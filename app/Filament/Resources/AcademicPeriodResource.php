<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicPeriodResource\Pages;
use App\Filament\Resources\AcademicPeriodResource\RelationManagers;
use App\Models\AcademicPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Auth;

class AcademicPeriodResource extends Resource
{
    protected static ?string $model = AcademicPeriod::class;
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?string $navigationLabel = 'Academic Periods';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    



    public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('school_year')
            ->label('School Year')
            ->required()
            ->maxLength(9)
            ->helperText('Format: YYYY-YYYY'),

        Select::make('semester')
            ->options([
                '1st Semester' => '1st Semester',
                '2nd Semester' => '2nd Semester',
                'Summer' => 'Summer',
            ])
            ->required(),

        Toggle::make('is_active')
            ->label('Is Active')
            ->helperText('Only one period should be active at a time.')
    ]);
}

public static function table(Table $table): Table
{
    return $table->columns([
        TextColumn::make('school_year')->sortable()->searchable(),
        TextColumn::make('semester')->sortable(),
        IconColumn::make('is_active')->boolean()->label('Active'),
        TextColumn::make('updated_at')->dateTime()->label('Updated'),
    ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicPeriods::route('/'),
            'create' => Pages\CreateAcademicPeriod::route('/create'),
            'edit' => Pages\EditAcademicPeriod::route('/{record}/edit'),
        ];
    }
    public static function beforeSave($record): void
{
    if ($record->is_active) {
        \App\Models\AcademicPeriod::where('id', '!=', $record->id)->update(['is_active' => false]);
    }
}
public static function canViewAny(): bool
{
    return Auth::user()?->hasAnyRole(['admin', 'superadmin']);
}


}
