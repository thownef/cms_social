<?php

namespace App\Repositories;

use App\Models\FriendSetting;

class FriendSettingRepository extends EloquentRepository implements \App\Contracts\Repositories\FriendSettingRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return FriendSetting::class;
    }
}
