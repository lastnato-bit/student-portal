<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\StudentResource\Pages\CreateStudent;
use Filament\Forms\Get;
use Filament\Forms\Components\BelongsToSelect;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('student_number')
            ->label('Student Number')
            ->required()
            ->unique(ignoreRecord: true),

        TextInput::make('lastname')->label('Last Name')->required(),
        TextInput::make('firstname')->label('First Name')->required(),
        TextInput::make('middlename')->label('Middle Name')->nullable(),

        TextInput::make('email')
            ->required()
            ->email()
            ->unique(ignoreRecord: true),

        // ✅ Automatically selected for Admin, editable for Superadmin
        BelongsToSelect::make('department_id')
            ->label('Department')
            ->relationship('department', 'name')
            ->default(fn () => auth()->user()?->department_id)
            ->disabled(auth()->user()?->hasRole('admin'))
            ->required()
            ->reactive(), // Needed for dynamic course loading

        Select::make('section_id')
            ->label('Section')
            ->relationship('section', 'name'),

        Select::make('gender')
            ->label('Gender')
            ->options([
                'Male' => 'Male',
                'Female' => 'Female',
                'Other' => 'Other',
                'Prefer not to say' => 'Prefer not to say',
            ])
            ->required(),

        DatePicker::make('birthdate')->nullable(),
        TextInput::make('contact_number')->nullable(),
        TextInput::make('address')->nullable(),

        // ✅ Shows courses only under selected department
        Select::make('course_id')
            ->label('Course')
            ->options(function (Get $get) {
                $departmentId = $get('department_id');

                if (!$departmentId) {
                    return [];
                }

                return \App\Models\Course::where('department_id', $departmentId)
                    ->pluck('name', 'id');
            })
            ->reactive()
            ->required()
            ->searchable()
            ->placeholder('Select a course'),

        Select::make('year_level')
            ->label('Year Level')
            ->options([
                '1st Year' => '1st Year',
                '2nd Year' => '2nd Year',
                '3rd Year' => '3rd Year',
                '4th Year' => '4th Year',
                '5th Year' => '5th Year',
            ])
            ->required()
            ->native(false)
            ->placeholder('Select year level'),

        Select::make('status')
            ->label('Enrollment Status')
            ->options([
                'pending' => 'Pending',
                'active' => 'Active',
                'inactive' => 'Inactive',
            ])
            ->default('pending')
            ->required(),

        Hidden::make('user_id'),
    ]);
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student_number')->sortable(),
                TextColumn::make('fullname')
                    ->label('Name')
                    ->getStateUsing(fn ($record) => "{$record->firstname} {$record->middlename} {$record->lastname}")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')->sortable(),
                TextColumn::make('department.name')->label('Department')->sortable(),
                BadgeColumn::make('status')
                    ->label('Enrollment Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Enrollment Status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                TrashedFilter::make(),
            ])
            ->actions([
                Action::make('Activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'active'])),

                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = static::getModel()::query()->withTrashed();

        if ($user->hasRole('superadmin')) {
            return $query;
        }

        return $query->where('department_id', optional($user)->department_id);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('admin') || auth()->user()?->hasRole('superadmin');
    }
}
