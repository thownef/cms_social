<?php

namespace App\Repositories;

use App\Models\WorkHistory;

class WorkHistoryRepository extends EloquentRepository implements \App\Contracts\Repositories\WorkHistoryRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return WorkHistory::class;
    }
}
