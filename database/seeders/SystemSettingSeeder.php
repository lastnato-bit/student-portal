<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'system_settings'],
            [
                'data' => [
                    'school_year' => '2024',
                    'semester' => '2nd',
                    'maintenance_mode' => false,
                    'announcement' => 'Welcome to the Student Portal!',
                ]
            ]
        );
    }
}
