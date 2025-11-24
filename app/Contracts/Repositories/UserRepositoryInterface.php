<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
  public function suggestedFriends();
}
