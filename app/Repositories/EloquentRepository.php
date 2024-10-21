<?php

namespace App\Repositories;

use App\Contracts\Repositories\EloquentRepositoryInterface;
use App\Repositories\Traits\HasQueryBuilder;

abstract class EloquentRepository implements EloquentRepositoryInterface
{
    use HasQueryBuilder;

    public $_model;

    public function __construct()
    {
        $this->setModel();
    }

    private function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    abstract public function getModel(): string;

    public function makeListBuilder()
    {
        return $this->makeQueryBuilder();
    }

    public function getAll($builder = null, $perPage = null)
    {
        $builder = (is_null($builder) ? $this->makeListBuilder() : $builder)
            ->defaultSort(...[$this->getDefaultSort()])
            ->allowedFields($this->getFields())
            ->allowedIncludes($this->getIncludes())
            ->allowedFilters($this->getFilters())
            ->allowedSorts($this->getSorts());

        return is_null($perPage) ? $builder->get() : $builder->paginate($perPage);
    }

    public function store(array $data)
    {
        return $this->_model->create($data)->fresh();
    }

    public function update($model, array $data)
    {
        return $model->update($data);
    }

    public function delete($model)
    {
        return $model->delete();
    }
}
