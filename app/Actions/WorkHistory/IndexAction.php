<?php

namespace App\Actions\WorkHistory;

use App\Actions\WorkHistory\BaseAction;
use App\Models\WorkHistory;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\WorkHistoryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class IndexAction extends BaseAction
{
    use HasPerPageRequest;

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return DB::transaction(function () {
            /**
             * @var WorkHistory $workHistory
             */
            $workHistory = $this->workHistoryRepository->forCurrentUser();

            return $this->httpOK($workHistory, WorkHistoryTransformer::class);
        });
    }
}
