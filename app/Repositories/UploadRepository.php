<?php

namespace App\Repositories;

use App\Models\Upload;
use Illuminate\Support\Collection;

class UploadRepository extends EloquentRepository implements \App\Contracts\Repositories\UploadRepositoryInterface
{
    protected array $allowedFilters = [
        'uploadable_type',
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

    public function getGroupType(): Collection
    {
        $types = $this->queryBuilder()
            ->collection()
            ->distinct()
            ->pluck('uploadable_type');

        $result = collect();
        
        foreach ($types as $type) {
            $uploads = $this->queryBuilder()
                ->where('uploadable_type', $type)
                ->whereHasMorph('uploadable', '*', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->take(6)
                ->get();
                
            $result->put($type, $uploads);
        }

        return $result;
    }
}
