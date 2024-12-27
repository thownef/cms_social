<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface EloquentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param mixed $limit
     * @param array $columns
     * @param string $method
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return LengthAwarePaginator|Collection|mixed
     */
    public function paginateOrAll($limit = null, array $columns = ['*'], string $method = 'paginate');

    /**
     * @return self
     */
    public function queryBuilder(): self;

    /**
     * @param array $with
     * @return Collection
     */
    public function exportQuery(array $with = []): Collection;
}
