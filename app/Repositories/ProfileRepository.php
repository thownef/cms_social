<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository extends EloquentRepository implements \App\Contracts\Repositories\ProfileRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return Profile::class;
    }
}
