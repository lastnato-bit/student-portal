<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // ✅ Save the user to $superadmin
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'firstname' => 'Mark',
                'lastname' => 'Onganiza',
                'middlename' => 'B.',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'is_verified' => 1,
            ]
        );

        $superadmin->assignRole('superadmin');
    }
}
