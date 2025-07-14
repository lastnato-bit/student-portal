<?php

namespace App\Filament\Resources;

use App\Models\User;
use App\Filament\Resources\AdminUserResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'Admin Users';

    public static function canViewAny(): bool
    {
        return Auth::check() && Auth::user()->hasRole('superadmin');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('roles', fn ($query) => $query->where('name', 'admin'));
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Personal Information')
                ->schema([
                    Forms\Components\TextInput::make('lastname')
                        ->label('Last Name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('firstname')
                        ->label('First Name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('middlename')
                        ->label('Middle Name')
                        ->nullable()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Select::make('department_id')
                        ->label('Department')
                        ->relationship('department', 'name')
                        ->required()
                        ->searchable(),
                ])->columns(2),

            Forms\Components\Section::make('Security & Roles')
                ->schema([
                    Forms\Components\Select::make('roles')
                        ->label('Roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->required()
                        ->options(
                            Role::where('name', 'admin')->pluck('name', 'id')
                        ),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->label('Password')
                        ->maxLength(255)
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->helperText('Leave blank to generate a random password.'),
                ])->columns(2),
        ]);
    }

    public static function beforeCreate(array $data): array
    {
        if (empty($data['password'])) {
            $randomPassword = Str::random(12);
            $data['password'] = Hash::make($randomPassword);
            // Optional: send to admin via email
        }

        if (!empty($data['roles'])) {
            $adminRoleId = Role::where('name', 'admin')->first()?->id;

            if (in_array($adminRoleId, $data['roles'])) {
                $data['must_change_password'] = true;
            }
        }

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fullname')
                    ->label('Name')
                    ->getStateUsing(fn ($record) => "{$record->firstname} {$record->middlename} {$record->lastname}")
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->colors([
                        'primary',
                        'success',
                        'warning',
                        'danger',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminUsers::route('/'),
            'create' => Pages\CreateAdminUser::route('/create'),
            'edit' => Pages\EditAdminUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->hasRole('superadmin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
}
