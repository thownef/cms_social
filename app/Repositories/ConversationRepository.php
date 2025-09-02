<?php

namespace App\Repositories;

use App\Models\Conversation;

class ConversationRepository extends EloquentRepository implements \App\Contracts\Repositories\ConversationRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return Conversation::class;
    }
}
