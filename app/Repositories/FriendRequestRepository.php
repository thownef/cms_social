<?php

namespace App\Repositories;

use App\Models\FriendRequest;
use Spatie\QueryBuilder\AllowedFilter;

class FriendRequestRepository extends EloquentRepository implements \App\Contracts\Repositories\FriendRequestRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
        $this->addFilters([
            AllowedFilter::exact('user_id'),
            AllowedFilter::exact('friend_id'),
        ]);
    }

    public function model(): string
    {
        return FriendRequest::class;
    }
}
