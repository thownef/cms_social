<?php

namespace App\Contracts\Repositories;

interface EloquentRepositoryInterface
{
    public function makeQueryBuilder();

    public function getAll($builder, $perPage = null);

    public function store(array $data);

    public function update($model, array $data);

    public function delete($model);

    // public function upload($model, $file);
}
