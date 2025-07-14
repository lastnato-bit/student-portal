<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'Users';

    public static function canViewAny(): bool
    {
        return Auth::check() && Auth::user()->hasAnyRole(['superadmin', 'admin']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('User Information')
                ->schema([
                    Forms\Components\TextInput::make('lastname')->required()->maxLength(255),
                    Forms\Components\TextInput::make('firstname')->required()->maxLength(255),
                    Forms\Components\TextInput::make('middlename')->maxLength(255),
                    Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
                    Forms\Components\Select::make('department_id')
                        ->label('Department')
                        ->relationship('department', 'name')
                        ->required()
                        ->searchable(),
                ])->columns(3),

            Forms\Components\Section::make('Security & Roles')
                ->schema([
                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->required()
                        ->label('Roles')
                        ->options(fn () => \Spatie\Permission\Models\Role::whereNot('name', 'student')->pluck('name', 'id')),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->maxLength(255)
                        ->label('Password')
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->helperText('Leave blank to generate a random password.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()?->hasRole('admin')) {
                    $query->whereDoesntHave('roles', function ($q) {
                        $q->where('name', 'superadmin');
                    });
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('fullname')
                    ->label('Name')
                    ->getStateUsing(fn ($record) => "{$record->firstname} {$record->middlename} {$record->lastname}")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('department.name')->label('Department')->sortable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Roles')->badge()->colors([
                    'primary',
                    'success',
                    'warning',
                    'danger',
                ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filter by Role')
                    ->options(function () {
                        return Auth::user()?->hasRole('superadmin')
                            ? [
                                'superadmin' => 'Superadmin',
                                'admin' => 'Admin',
                                'student' => 'Student',
                            ]
                            : [
                                'admin' => 'Admin',
                                'student' => 'Student',
                            ];
                    })
                    ->query(function ($query, array $data) {
                        if ($data['value'] ?? false) {
                            $query->whereHas('roles', function ($q) use ($data) {
                                $q->where('name', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn () => Auth::user()?->hasRole('superadmin')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->hasRole('superadmin')),
                ]),
            ]);
    }

    public static function afterCreate($record): void
    {
        if (!$record->password) {
            $randomPassword = Str::random(12);
            $record->update([
                'password' => Hash::make($randomPassword),
            ]);
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->withProperties([
                'email' => $record->email,
                'roles' => $record->roles->pluck('name'),
            ])
            ->log('Created a user');
    }

    public static function afterSave($record): void
    {
        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->withProperties([
                'email' => $record->email,
                'roles' => $record->roles->pluck('name'),
            ])
            ->log('Updated a user');
    }

    public static function afterDelete($record): void
    {
        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->withProperties([
                'email' => $record->email,
                'roles' => $record->roles->pluck('name'),
            ])
            ->log('Deleted a user');
    }

    public static function getPages(): array
{
    return [
        'index' => Pages\ListUsers::route('/'),
        'create' => Pages\CreateUser::route('/create'),
        'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
}


    public static function canAccess(): bool
    {
        return Auth::user()?->hasAnyRole(['superadmin', 'admin']);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->hasAnyRole(['superadmin', 'admin']);
    }
}
