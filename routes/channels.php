<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('online', function ($user) {
    return $user;
}, ['guards' => ['api']]);

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    return $user->id === $conversationId;
}, ['guards' => ['api']]);
