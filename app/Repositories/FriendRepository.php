<?php

namespace App\Repositories;

use App\Models\Friend;

class FriendRepository extends EloquentRepository implements \App\Contracts\Repositories\FriendRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return Friend::class;
    }
}
