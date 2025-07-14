<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassScheduleResource\Pages;
use App\Models\ClassSchedule;
use App\Models\Instructor;
use App\Models\Section;
use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClassScheduleResource extends Resource
{
    protected static ?string $model = ClassSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?string $navigationLabel = 'Class Schedules';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('superadmin');

        return $form->schema([
            Select::make('department_id')
                ->label('Department')
                ->options(Department::pluck('name', 'id'))
                ->reactive()
                ->required()
                ->visible($isSuperAdmin),

            Select::make('course_id')
                ->label('Course')
                ->options(function (callable $get) use ($user, $isSuperAdmin) {
                    $departmentId = $isSuperAdmin ? $get('department_id') : $user->department_id;
                    if (!$departmentId) return [];
                    return Course::where('department_id', $departmentId)->pluck('name', 'id');
                })
                ->reactive()
                ->required(),

            Select::make('subject_id')
    ->label('Subject')
    ->required()
    ->searchable()
    ->options(function (callable $get) {
        $courseId = $get('course_id');
        if (!$courseId) return [];
        return Subject::where('course_id', $courseId)->pluck('name', 'id');
    })
    ->reactive()
    ->afterStateUpdated(function ($state, callable $set) {
        $subject = \App\Models\Subject::find($state);
        if ($subject) {
            $set('units', $subject->units);
            $set('course_id', $subject->course_id); // optional autofill
        }
    }),

            Select::make('section_id')
                ->label('Section')
                ->options(function (callable $get) use ($user, $isSuperAdmin) {
                    $departmentId = $isSuperAdmin ? $get('department_id') : $user->department_id;
                    if (!$departmentId) return [];
                    return Section::where('department_id', $departmentId)->pluck('name', 'id');
                })
                ->searchable()
                ->required(),

            Select::make('instructor_id')
                ->label('Instructor')
                ->options(function (callable $get) use ($user, $isSuperAdmin) {
                    $departmentId = $isSuperAdmin ? $get('department_id') : $user->department_id;
                    return Instructor::where('department_id', $departmentId)
                        ->orderBy('lastname')
                        ->get()
                        ->pluck('full_name', 'id');
                })
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('units')
    ->label('Units')
    ->numeric()
    ->required()
    ->disabled() // because it’s auto-filled
    ->dehydrated(),

            Select::make('day')->label('Day')->options([
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
            ])->required(),

            TimePicker::make('start_time')->required(),
            TimePicker::make('end_time')->required(),
            TextInput::make('room')->nullable(),
            Select::make('semester')->options([
                '1st' => '1st Semester',
                '2nd' => '2nd Semester',
                'summer' => 'Summer',
            ])->required(),

            TextInput::make('school_year')->placeholder('e.g., 2025-2026')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section.name')->label('Section'),
                TextColumn::make('course.name')->label('Course'),
                TextColumn::make('subject.name')->label('Subject'),
                TextColumn::make('units')->label('Units'),
                TextColumn::make('instructor.full_name')->label('Instructor')->sortable()->searchable(),
                TextColumn::make('day')->sortable(),
                TextColumn::make('start_time')->label('Start')->sortable(),
                TextColumn::make('end_time')->label('End')->sortable(),
                TextColumn::make('room')->sortable(),
                TextColumn::make('semester'),
                TextColumn::make('school_year'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassSchedules::route('/'),
            'create' => Pages\CreateClassSchedule::route('/create'),
            'edit' => Pages\EditClassSchedule::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        $query = static::getModel()::query()->with(['instructor', 'subject']);

        if ($user->hasRole('superadmin')) {
            return $query;
        }

        return $query->whereHas('section', function ($q) use ($user) {
            $q->where('department_id', $user->department_id);
        });
    }
}
