<?php

use App\Enums\RequestFriendEnum;
use App\Enums\TypeFriendEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('friend_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('status')->default(RequestFriendEnum::PENDING);
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'friend_id']);
        });

        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('friend_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('friend_type')->default(TypeFriendEnum::ACQUAINTANCE);
            $table->boolean('is_favorite')->default(false);
            $table->timestamp('blocked_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'friend_id']);
        });

        Schema::create('friend_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('show_friendship')->default(true);
            $table->boolean('show_posts')->default(true);
            $table->timestamps();
        });

        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('following_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('show_posts')->default(true);
            $table->timestamps();
            $table->unique(['follower_id', 'following_id']);
        });

        Schema::create('friendship_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('new_friend_request')->default(true);
            $table->boolean('accepted_friend_request')->default(true);
            $table->boolean('friend_birthday')->default(true);
            $table->boolean('friend_life_event')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_ships');
        Schema::dropIfExists('friendship_notification_settings');
        Schema::dropIfExists('follows');
        Schema::dropIfExists('friend_lists');
    }
};
