<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Mail\SendStudentAccountCredentials;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            if (empty($data['department_id'])) {
                $data['department_id'] = Auth::user()?->department_id;
            }

            if (User::where('email', $data['email'])->exists()) {
                throw ValidationException::withMessages([
                    'email' => 'This email is already taken.',
                ]);
            }

            $password = Str::random(10);

            $fullName = trim("{$data['lastname']}, {$data['firstname']} {$data['middlename']}");

            $user = User::create([
                'firstname'     => $data['firstname'],
                'middlename'    => $data['middlename'],
                'lastname'      => $data['lastname'],
                'name'          => $fullName,
                'email'         => $data['email'],
                'password'      => Hash::make($password),
                'department_id' => $data['department_id'],
            ]);

            $user->assignRole('student');

            try {
                Mail::to($user->email)->send(new SendStudentAccountCredentials($user, $password));
            } catch (\Throwable $mailException) {
                Log::warning('Mail not sent: ' . $mailException->getMessage());
            }

            $data['user_id'] = $user->id;

            return $data;

        } catch (\Throwable $e) {
            Log::error('Error creating student: ' . $e->getMessage(), ['trace' => $e->getTrace()]);
            throw $e;
        }
    }

    protected function getRedirectUrl(): string
    {
        return StudentResource::getUrl('index');
    }
}