<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('online', function () {
    return true;
}, ['guards' => ['sanctum']]);
