<?php

namespace App\Observers;

use App\Enums\RequestFriendEnum;
use App\Models\Friend;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendRequestObserver
{
    /**
     * Handle the FriendRequest "created" event.
     */
    public function created(FriendRequest $friendRequest): void
    {
        //
    }

    /**
     * Handle the FriendRequest "updated" event.
     */
    public function updated(FriendRequest $friendRequest): void
    {
        $status = data_get($friendRequest, 'status');

        if ((int) $status === RequestFriendEnum::ACCEPTED) {
            Friend::insert([
                [
                    'user_id' => $friendRequest->user_id,
                    'friend_id' => $friendRequest->friend_id
                ],
                [
                    'user_id' => $friendRequest->friend_id,
                    'friend_id' => $friendRequest->user_id
                ]
            ]);
        }
    }

    /**
     * Handle the FriendRequest "deleted" event.
     */
    public function deleted(FriendRequest $friendRequest): void
    {
        //
    }

    /**
     * Handle the FriendRequest "restored" event.
     */
    public function restored(FriendRequest $friendRequest): void
    {
        //
    }

    /**
     * Handle the FriendRequest "force deleted" event.
     */
    public function forceDeleted(FriendRequest $friendRequest): void
    {
        //
    }
}
