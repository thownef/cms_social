<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends EloquentRepository implements \App\Contracts\Repositories\UserRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return User::class;
    }
}
