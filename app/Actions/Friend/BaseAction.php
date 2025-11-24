<?php

namespace App\Actions\Friend;

use App\Repositories\FriendRepository;
use App\Repositories\UserRepository;
use App\Supports\Traits\HasTransformer;

abstract class BaseAction
{
    use HasTransformer;

    protected FriendRepository $friendRepository;
    protected UserRepository $userRepository;

    public function __construct(FriendRepository $friendRepository, UserRepository $userRepository)
    {
        $this->friendRepository = $friendRepository;
        $this->userRepository = $userRepository;
    }
}
