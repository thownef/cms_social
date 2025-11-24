<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {

    // Authentication
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register'])->name('register');
        Route::post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('login');
        Route::post('forgot-password', [\App\Http\Controllers\Api\V1\AuthController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('reset-password', [\App\Http\Controllers\Api\V1\AuthController::class, 'resetPassword'])->name('reset-password');

        // Social OAuth (if needed)
        Route::post('social/{provider}', [\App\Http\Controllers\Api\V1\AuthController::class, 'socialLogin'])->name('social');
    });

    // Public content
    Route::prefix('public')->name('public.')->group(function () {
        Route::get('profiles/{username}', [\App\Http\Controllers\Api\V1\ProfileController::class, 'showPublic'])->name('profiles.show');
        Route::get('posts/{post}', [\App\Http\Controllers\Api\V1\PostController::class, 'showPublic'])->name('posts.show');
    });

    // Protected routes
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {

        // Authentication
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::get('me', [\App\Http\Controllers\Api\V1\AuthController::class, 'me'])->name('me');
            Route::post('logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->name('logout');
            Route::post('refresh', [\App\Http\Controllers\Api\V1\AuthController::class, 'refresh'])->name('refresh');
        });

        // User profile & settings
        Route::prefix('user')->name('user.')->group(function () {
            // Current user profile
            Route::get('profile', [\App\Http\Controllers\Api\V1\UserController::class, 'profile'])->name('profile');
            Route::put('profile', [\App\Http\Controllers\Api\V1\UserController::class, 'updateProfile'])->name('profile.update');

            // Profile media
            Route::post('profile/avatar', [\App\Http\Controllers\Api\V1\UserController::class, 'uploadAvatar'])->name('profile.avatar');
            Route::post('profile/cover', [\App\Http\Controllers\Api\V1\UserController::class, 'uploadCover'])->name('profile.cover');
            Route::delete('profile/avatar', [\App\Http\Controllers\Api\V1\UserController::class, 'deleteAvatar'])->name('profile.avatar.delete');
            Route::delete('profile/cover', [\App\Http\Controllers\Api\V1\UserController::class, 'deleteCover'])->name('profile.cover.delete');

            // Work & Education History
            Route::apiResource('work-history', \App\Http\Controllers\Api\V1\WorkHistoryController::class);
            Route::apiResource('education', \App\Http\Controllers\Api\V1\EducationController::class);

            // Privacy & Settings
            Route::get('settings', [\App\Http\Controllers\Api\V1\UserController::class, 'settings'])->name('settings');
            Route::put('settings', [\App\Http\Controllers\Api\V1\UserController::class, 'updateSettings'])->name('settings.update');
            Route::put('privacy', [\App\Http\Controllers\Api\V1\UserController::class, 'updatePrivacy'])->name('privacy.update');
        });

        // Profiles (Other users)
        Route::prefix('profiles')->name('profiles.')->group(function () {
            Route::get('{username}', [\App\Http\Controllers\Api\V1\ProfileController::class, 'show'])->name('show');
            Route::get('{username}/posts', [\App\Http\Controllers\Api\V1\ProfileController::class, 'posts'])->name('posts');
            Route::get('{username}/friends', [\App\Http\Controllers\Api\V1\ProfileController::class, 'friends'])->name('friends');
            Route::get('{username}/photos', [\App\Http\Controllers\Api\V1\ProfileController::class, 'photos'])->name('photos');
        });

        // Newsfeed & Timeline
        Route::prefix('feed')->name('feed.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\V1\NewsfeedController::class, 'index'])->name('index');
            Route::get('timeline/{username}', [\App\Http\Controllers\Api\V1\NewsfeedController::class, 'timeline'])->name('timeline');
        });

        // Posts & Content
        Route::apiResource('posts', \App\Http\Controllers\Api\V1\PostController::class);

        // Post interactions (nested resources)
        Route::prefix('posts/{post}')->name('posts.')->group(function () {
            // Reactions (Like, Love, Haha, etc.)
            Route::post('reactions', [\App\Http\Controllers\Api\V1\PostReactionController::class, 'store'])->name('reactions.store');
            Route::delete('reactions', [\App\Http\Controllers\Api\V1\PostReactionController::class, 'destroy'])->name('reactions.destroy');
            Route::get('reactions', [\App\Http\Controllers\Api\V1\PostReactionController::class, 'index'])->name('reactions.index');

            // Comments
            Route::apiResource('comments', \App\Http\Controllers\Api\V1\CommentController::class)->shallow();

            // Shares
            Route::post('share', [\App\Http\Controllers\Api\V1\ShareController::class, 'store'])->name('share');
            Route::get('shares', [\App\Http\Controllers\Api\V1\ShareController::class, 'index'])->name('shares');

            // Privacy
            Route::put('privacy', [\App\Http\Controllers\Api\V1\PostController::class, 'updatePrivacy'])->name('privacy');
        });

        // Comment reactions (nested)
        Route::prefix('comments/{comment}')->name('comments.')->group(function () {
            Route::post('reactions', [\App\Http\Controllers\Api\V1\CommentReactionController::class, 'store'])->name('reactions.store');
            Route::delete('reactions', [\App\Http\Controllers\Api\V1\CommentReactionController::class, 'destroy'])->name('reactions.destroy');

            // Nested replies
            Route::apiResource('replies', \App\Http\Controllers\Api\V1\CommentReplyController::class)->shallow();
        });

        // Shares management
        Route::prefix('shares')->name('shares.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\V1\ShareController::class, 'myShares'])->name('index');
            Route::delete('{share}', [\App\Http\Controllers\Api\V1\ShareController::class, 'destroy'])->name('destroy');
        });

        // Social connections
        Route::prefix('friends')->name('friends.')->group(function () {
            // Friends list
            Route::get('/', [\App\Http\Controllers\Api\V1\FriendController::class, 'index'])->name('index');
            Route::delete('{friend}', [\App\Http\Controllers\Api\V1\FriendController::class, 'destroy'])->name('destroy');

            // Friend suggestions
            Route::get('suggestions', [\App\Http\Controllers\Api\V1\FriendController::class, 'suggestions'])->name('suggestions');
            Route::get('mutual/{username}', [\App\Http\Controllers\Api\V1\FriendController::class, 'mutual'])->name('mutual');
        });

        Route::prefix('friend-requests')->name('friend-requests.')->group(function () {
            // Incoming requests
            Route::get('received', [\App\Http\Controllers\Api\V1\FriendRequestController::class, 'received'])->name('received');
            // Outgoing requests
            Route::get('sent', [\App\Http\Controllers\Api\V1\FriendRequestController::class, 'sent'])->name('sent');
            // Send request
            Route::post('/', [\App\Http\Controllers\Api\V1\FriendRequestController::class, 'store'])->name('store');
            // Accept/Reject
            Route::put('{request}/accept', [\App\Http\Controllers\Api\V1\FriendRequestController::class, 'accept'])->name('accept');
            Route::put('{request}/reject', [\App\Http\Controllers\Api\V1\FriendRequestController::class, 'reject'])->name('reject');
            // Cancel sent request
            Route::delete('{request}', [\App\Http\Controllers\Api\V1\FriendRequestController::class, 'destroy'])->name('destroy');
        });

        // Followers (if your app supports follow without friend request)
        Route::prefix('follow')->name('follow.')->group(function () {
            Route::post('{username}', [\App\Http\Controllers\Api\V1\FollowController::class, 'follow'])->name('store');
            Route::delete('{username}', [\App\Http\Controllers\Api\V1\FollowController::class, 'unfollow'])->name('destroy');
            Route::get('followers', [\App\Http\Controllers\Api\V1\FollowController::class, 'followers'])->name('followers');
            Route::get('following', [\App\Http\Controllers\Api\V1\FollowController::class, 'following'])->name('following');
        });

        // Messaging & Chat
        Route::prefix('conversations')->name('conversations.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\V1\ConversationController::class, 'index'])->name('index');
            Route::post('/', [\App\Http\Controllers\Api\V1\ConversationController::class, 'store'])->name('store');
            Route::get('{conversation}', [\App\Http\Controllers\Api\V1\ConversationController::class, 'show'])->name('show');
            Route::delete('{conversation}', [\App\Http\Controllers\Api\V1\ConversationController::class, 'destroy'])->name('destroy');

            // Messages in conversation
            Route::get('{conversation}/messages', [\App\Http\Controllers\Api\V1\MessageController::class, 'index'])->name('messages.index');
            Route::post('{conversation}/messages', [\App\Http\Controllers\Api\V1\MessageController::class, 'store'])->name('messages.store');

            // Conversation actions
            Route::post('{conversation}/mark-read', [\App\Http\Controllers\Api\V1\ConversationController::class, 'markAsRead'])->name('mark-read');
            Route::post('{conversation}/mute', [\App\Http\Controllers\Api\V1\ConversationController::class, 'mute'])->name('mute');
            Route::post('{conversation}/unmute', [\App\Http\Controllers\Api\V1\ConversationController::class, 'unmute'])->name('unmute');
        });

        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('{message}', [\App\Http\Controllers\Api\V1\MessageController::class, 'show'])->name('show');
            Route::put('{message}', [\App\Http\Controllers\Api\V1\MessageController::class, 'update'])->name('update');
            Route::delete('{message}', [\App\Http\Controllers\Api\V1\MessageController::class, 'destroy'])->name('destroy');

            // Message reactions
            Route::post('{message}/reactions', [\App\Http\Controllers\Api\V1\MessageReactionController::class, 'store'])->name('reactions.store');
            Route::delete('{message}/reactions', [\App\Http\Controllers\Api\V1\MessageReactionController::class, 'destroy'])->name('reactions.destroy');
        });

        // Notifications
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\V1\NotificationController::class, 'index'])->name('index');
            Route::get('unread-count', [\App\Http\Controllers\Api\V1\NotificationController::class, 'unreadCount'])->name('unread-count');
            Route::post('mark-all-read', [\App\Http\Controllers\Api\V1\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            Route::post('{notification}/mark-read', [\App\Http\Controllers\Api\V1\NotificationController::class, 'markAsRead'])->name('mark-read');
            Route::delete('{notification}', [\App\Http\Controllers\Api\V1\NotificationController::class, 'destroy'])->name('destroy');
        });

        // Search
        Route::prefix('search')->name('search.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\V1\SearchController::class, 'index'])->name('index');
            Route::get('users', [\App\Http\Controllers\Api\V1\SearchController::class, 'users'])->name('users');
            Route::get('posts', [\App\Http\Controllers\Api\V1\SearchController::class, 'posts'])->name('posts');
            Route::get('hashtags', [\App\Http\Controllers\Api\V1\SearchController::class, 'hashtags'])->name('hashtags');
        });

        // Media & Uploads
        Route::prefix('media')->name('media.')->group(function () {
            Route::post('upload', [\App\Http\Controllers\Api\V1\MediaController::class, 'upload'])->name('upload');
            Route::post('upload-multiple', [\App\Http\Controllers\Api\V1\MediaController::class, 'uploadMultiple'])->name('upload-multiple');
            Route::get('/', [\App\Http\Controllers\Api\V1\MediaController::class, 'index'])->name('index');
            Route::get('{media}', [\App\Http\Controllers\Api\V1\MediaController::class, 'show'])->name('show');
            Route::delete('{media}', [\App\Http\Controllers\Api\V1\MediaController::class, 'destroy'])->name('destroy');

            // Group by type
            Route::get('type/{type}', [\App\Http\Controllers\Api\V1\MediaController::class, 'byType'])->name('by-type');
        });

        // Groups (Optional - if you have groups feature)
        Route::apiResource('groups', \App\Http\Controllers\Api\V1\GroupController::class);
        Route::prefix('groups/{group}')->name('groups.')->group(function () {
            Route::post('join', [\App\Http\Controllers\Api\V1\GroupMemberController::class, 'join'])->name('join');
            Route::post('leave', [\App\Http\Controllers\Api\V1\GroupMemberController::class, 'leave'])->name('leave');
            Route::get('members', [\App\Http\Controllers\Api\V1\GroupMemberController::class, 'index'])->name('members');
            Route::get('posts', [\App\Http\Controllers\Api\V1\GroupPostController::class, 'index'])->name('posts');
        });

        // Pages (Optional - if you have pages feature)
        Route::apiResource('pages', \App\Http\Controllers\Api\V1\PageController::class);
        Route::prefix('pages/{page}')->name('pages.')->group(function () {
            Route::post('like', [\App\Http\Controllers\Api\V1\PageLikeController::class, 'like'])->name('like');
            Route::delete('unlike', [\App\Http\Controllers\Api\V1\PageLikeController::class, 'unlike'])->name('unlike');
            Route::get('posts', [\App\Http\Controllers\Api\V1\PagePostController::class, 'index'])->name('posts');
        });

        // Reports & Moderation
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::post('/', [\App\Http\Controllers\Api\V1\ReportController::class, 'store'])->name('store');
            Route::get('/', [\App\Http\Controllers\Api\V1\ReportController::class, 'index'])->name('index');
        });

        Route::prefix('blocks')->name('blocks.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\V1\BlockController::class, 'index'])->name('index');
            Route::post('{username}', [\App\Http\Controllers\Api\V1\BlockController::class, 'block'])->name('store');
            Route::delete('{username}', [\App\Http\Controllers\Api\V1\BlockController::class, 'unblock'])->name('destroy');
        });

        // Utilities & Helpers
        Route::prefix('utilities')->name('utilities.')->group(function () {
            Route::get('countries', [\App\Http\Controllers\Api\V1\UtilityController::class, 'countries'])->name('countries');
            Route::get('cities/{country}', [\App\Http\Controllers\Api\V1\UtilityController::class, 'cities'])->name('cities');
            Route::get('timezones', [\App\Http\Controllers\Api\V1\UtilityController::class, 'timezones'])->name('timezones');
            Route::get('languages', [\App\Http\Controllers\Api\V1\UtilityController::class, 'languages'])->name('languages');
        });
    });
});
