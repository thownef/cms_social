<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends EloquentRepository implements \App\Contracts\Repositories\PostRepositoryInterface
{
    protected array $allowedFilters = [];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return Post::class;
    }
}
