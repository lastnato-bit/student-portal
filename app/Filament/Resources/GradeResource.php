<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Models\Grade;
use App\Models\User;
use App\Models\ClassSchedule;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Student Records';
    protected static ?string $navigationLabel = 'Grades';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('student_id')
                ->label('Student')
                ->required()
                ->searchable()
                ->reactive()
                ->options(function () {
                    $query = User::whereHas('roles', fn ($q) => $q->where('name', 'student'));

                    if (Auth::user()->hasRole('admin')) {
                        $query->where('department_id', Auth::user()->department_id);
                    }

                    return $query->get()->mapWithKeys(fn ($user) => [
                        $user->id => "{$user->lastname}, {$user->firstname} ({$user->email})",
                    ]);
                }),

            Select::make('class_schedule_id')
                ->label('Class Schedule')
                ->required()
                ->searchable()
                ->reactive()
                ->options(function (callable $get) {
                    $studentId = $get('student_id');
                    if (!$studentId) return [];

                    $student = User::with(['student.section.classSchedules.course', 'student.section.classSchedules.instructor', 'grades'])->find($studentId);

                    if (!$student || !$student->student || !$student->student->section) return [];

                    $gradedIds = $student->grades->pluck('class_schedule_id')->toArray();

                    return $student->student->section->classSchedules
                        ->filter(fn ($schedule) => !in_array($schedule->id, $gradedIds))
                        ->mapWithKeys(fn ($schedule) => [
                            $schedule->id => $schedule->course->name . ' - ' . $schedule->instructor->full_name,
                        ])
                        ->toArray();
                })
                ->afterStateUpdated(function ($state, callable $set) {
                    $schedule = ClassSchedule::with('subject')->find($state);
                    if ($schedule) {
                        $set('semester', $schedule->semester);
                        $set('school_year', $schedule->school_year);
                        // No need to manually set subject – we’ll use relation when displaying
                    } else {
                        $set('semester', null);
                        $set('school_year', null);
                    }
                }),

            TextInput::make('semester')
                ->label('Semester')
                ->required()
                ->disabled()
                ->dehydrated(),

            TextInput::make('school_year')
                ->label('School Year')
                ->required()
                ->disabled()
                ->dehydrated(),

            TextInput::make('grade')
                ->label('Grade')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.full_name')->label('Student')->sortable()->searchable(),
                TextColumn::make('classSchedule.subject.name')->label('Subject')->sortable()->searchable(),
                TextColumn::make('classSchedule.instructor.full_name')->label('Instructor')->sortable()->searchable(),
                TextColumn::make('classSchedule.semester')->label('Semester')->sortable(),
                TextColumn::make('classSchedule.school_year')->label('School Year')->sortable(),
                TextColumn::make('grade')->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->whereHas('student', function ($query) use ($user) {
            $query->where('department_id', $user->department_id);
        });
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasRole('admin') || Auth::user()?->hasRole('superadmin');
    }
}
