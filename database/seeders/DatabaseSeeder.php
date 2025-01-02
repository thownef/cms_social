<?php

namespace Database\Seeders;

use App\Enums\LoginTypeEnum;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::unsetEventDispatcher();

        User::create([
            'email' => 'test@gmail.com',
            'phone' => '0123456789',
            'login_type' => LoginTypeEnum::NORMAL,
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
        ])->profile()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'gender' => 1,
            'date_of_birth' => now(),
            'location' => 'Test Location',
            'biography' => 'Test Biography',
            'is_active' => true
        ]);

        User::factory(10)->create()->each(function ($user) {
            $user->profile()->create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'gender' => fake()->numberBetween(1, 2),
                'date_of_birth' => now(),
                'location' => fake()->city(),
                'biography' => fake()->text(200),
                'is_active' => true
            ]);
        });

        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789')
        ]);
    }
}
