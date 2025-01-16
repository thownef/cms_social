<?php

namespace Database\Seeders;

use App\Enums\LoginTypeEnum;
use App\Models\Admin;
use App\Models\Group;
use App\Models\Message;
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

        $user = User::create([
            'email' => 'test@gmail.com',
            'phone' => '0123456789',
            'login_type' => LoginTypeEnum::NORMAL,
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
        ]);

        $user->profile()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'gender' => 1,
            'date_of_birth' => fake()->dateTimeBetween('-50 years', '-18 years'),
            'location' => fake()->city(),
            'biography' => fake()->text(200),
            'is_active' => true
        ]);

        $user->friendSettings()->create([]);

        $user1 = User::create([
            'email' => 'test1@gmail.com',
            'phone' => '0123456799',
            'login_type' => LoginTypeEnum::NORMAL,
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
        ]);

        $user1->profile()->create([
            'first_name' => 'Test 1',
            'last_name' => 'User',
            'gender' => 1,
            'date_of_birth' => fake()->dateTimeBetween('-50 years', '-18 years'),
            'location' => fake()->city(),
            'biography' => fake()->text(200),
            'is_active' => true
        ]);

        $user1->friendSettings()->create([]);

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

            $user->friendSettings()->create([]);
        });

        for ($i = 0; $i < 10; $i++) {
            $group = Group::factory()->create(['owner_id' => 1]);
            $users = User::inRandomOrder()->limit(rand(2, 10))->pluck('id');
            $group->users()->attach(array_unique([1, ...$users]));
        }

        Message::factory(100)->create();
        $messages = Message::whereNull('group_id')->orderBy('created_at')->get();
        $conversations = $messages->groupBy(function ($message) {
            return collect([$message->sender_id, $message->receiver_id])->sort()->implode('-');
        })->map(function ($groupedMessages) {
            return [
                'user_id1' => $groupedMessages->first()->sender_id,
                'user_id2' => $groupedMessages->first()->receiver_id,
                'last_message_id' => $groupedMessages->last()->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        })->values();

        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789')
        ]);
    }
}
