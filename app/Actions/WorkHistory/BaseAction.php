<?php

namespace App\Actions\WorkHistory;

use App\Repositories\WorkHistoryRepository;
use App\Supports\Traits\HasTransformer;

abstract class BaseAction
{
    use HasTransformer;

    protected WorkHistoryRepository $workHistoryRepository;

    public function __construct(WorkHistoryRepository $workHistoryRepository)
    {
        $this->workHistoryRepository = $workHistoryRepository;
    }
}
