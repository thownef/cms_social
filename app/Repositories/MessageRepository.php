<?php

namespace App\Repositories;

use App\Models\Message;
use Spatie\QueryBuilder\AllowedFilter;

class MessageRepository extends EloquentRepository implements \App\Contracts\Repositories\MessageRepositoryInterface
{
    protected array $allowedFilters = ['conversation_id'];
    protected array $allowedSorts = ['-created_at'];

    public function boot(): void
    {
        parent::boot();
        $this->addFilters([
            AllowedFilter::exact('conversation_id'),
            AllowedFilter::callback('cursor', function ($query, $value) {
                $query->where('created_at', '<', $value);
            }),
        ]);
    }

    public function model(): string
    {
        return Message::class;
    }
}
