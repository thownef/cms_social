<?php

namespace App\Actions\FriendRequest;

use App\Repositories\FriendRequestRepository;
use App\Supports\Traits\HasTransformer;

abstract class BaseAction
{
    use HasTransformer;

    protected FriendRequestRepository $friendRequestRepository;

    public function __construct(FriendRequestRepository $friendRequestRepository)
    {
        $this->friendRequestRepository = $friendRequestRepository;
    }
}
