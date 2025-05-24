<?php

namespace Database\Seeders;

use App\Enums\LoginTypeEnum;
use App\Models\Admin;
use App\Models\Conversation;
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
            $group->groupUsers()->attach(array_unique([1, ...$users]), ['created_at' => now(), 'updated_at' => now()]);
        }


        $users = User::all();
        foreach ($users as $user) {
            $otherUsers = $users->where('id', '!=', $user->id)->random(min(3, $users->count() - 1));

            foreach ($otherUsers as $otherUser) {
                $userIds = [$user->id, $otherUser->id];
                sort($userIds);
                $conversationExists = Conversation::whereHas('participants', function ($query) use ($userIds) {
                    $query->whereIn('user_id', $userIds);
                }, '=', count($userIds))->where('is_group', 0)->exists();

                if (!$conversationExists) {
                    $conversation = Conversation::create([
                        'is_group' => 0,
                        'group_id' => null
                    ]);

                    $conversation->participants()->attach($userIds, ['created_at' => now(), 'updated_at' => now()]);

                    $messageCount = rand(5, 15);
                    for ($i = 0; $i < $messageCount; $i++) {
                        $senderId = rand(0, 1) ? $user->id : $otherUser->id;

                        Message::create([
                            'conversation_id' => $conversation->id,
                            'user_id' => $senderId,
                            'message' => fake()->realText(rand(20, 150)),
                            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
                        ]);
                    }

                    $lastMessage = Message::where('conversation_id', $conversation->id)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($lastMessage) {
                        $conversation->update(['last_message_id' => $lastMessage->id]);
                    }
                }
            }
        }

        for ($i = 0; $i < 5; $i++) {
            $conversation = Conversation::create([
                'is_group' => 1,
                'group_id' => Group::inRandomOrder()->first()->id
            ]);

            $groupUsers = $users->random(rand(3, min(6, $users->count())));
            $conversation->participants()->attach($groupUsers->pluck('id')->toArray(), ['created_at' => now(), 'updated_at' => now()]);

            $messageCount = rand(10, 20);
            for ($j = 0; $j < $messageCount; $j++) {
                $sender = $groupUsers->random();

                Message::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $sender->id,
                    'message' => fake()->realText(rand(20, 150)),
                    'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
                ]);
            }

            $lastMessage = Message::where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastMessage) {
                $conversation->update(['last_message_id' => $lastMessage->id]);
            }
        }

        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789')
        ]);
    }
}
