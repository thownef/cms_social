<?php

namespace App\Repositories;

use App\Enums\TypeUploadEnum;
use App\Models\Upload;
use Illuminate\Support\Collection;

class UploadRepository extends EloquentRepository implements \App\Contracts\Repositories\UploadRepositoryInterface
{
    protected array $allowedFilters = [
        'uploadable_type',
        'type',
    ];

    protected array $allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return Upload::class;
    }

    public function getGroupType(): array
    {
        $uploads = $this->queryBuilder()->collection()->get();

        return [
            'posts' => $uploads->filter(
                fn($item) =>
                $item->uploadable_type === 'App\Models\Post' && $item->type === TypeUploadEnum::Post
            )->take(6)->values(),

            'avatars' => $uploads->filter(
                fn($item) =>
                $item->uploadable_type === 'App\Models\Profile' && $item->type === TypeUploadEnum::Avatar
            )->take(6)->values(),

            'covers' => $uploads->filter(
                fn($item) =>
                $item->uploadable_type === 'App\Models\Profile' && $item->type === TypeUploadEnum::Cover
            )->take(6)->values()
        ];
    }
}
