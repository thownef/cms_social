<?php

namespace App\Repositories\Traits;

use Spatie\QueryBuilder\QueryBuilder;

trait HasQueryBuilder
{
    // Allow Fields
    protected function getFields()
    {
        $fields = ['id'];
        if (property_exists($this, 'fields')) {
            $fields = array_merge($fields, $this->fields);
        } else {
            $fields = array_merge($fields, $this->_model->getFillable());
        }

        return $fields;
    }

    // Allow Includes
    protected function getIncludes()
    {
        $includes = [];
        if (method_exists($this, 'canIncludes')) {
            $includes = array_merge($includes, $this->canIncludes());
        }

        return $includes;
    }

    // Allow Filters
    protected function getFilters()
    {
        $filters = ['created_at', 'updated_at'];
        if (method_exists($this, 'canFilters')) {
            $filters = array_merge($filters, $this->canFilters());
        }

        return $filters;
    }

    protected function getSorts()
    {
        $sorts = ['created_at', 'updated_at'];
        if (method_exists($this, 'canSorts')) {
            $sorts = array_merge($sorts, $this->canSorts());
        }

        return $sorts;
    }

    protected function getDefaultSort()
    {
        if (property_exists($this, 'defaultSort')) {
            return $this->defaultSort;
        } else {
            return [
                '-'.$this->_model->getTable().'.updated_at',
                '-'.$this->_model->getTable().'.id',
            ];
        }
    }

    // Make Query Builder
    public function makeQueryBuilder(): QueryBuilder
    {
        return QueryBuilder::for($this->getModel());
    }
}
