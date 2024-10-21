<?php

namespace App\Repositories;

class UserRepository extends EloquentRepository implements \App\Contracts\Repositories\UserRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\User::class;
    }

    protected $fields = [
        'name',
        'email',
    ];

    protected function canSorts()
    {
        return [

        ];
    }

    protected function canFilters()
    {
        return [
           
        ];
    }
}
