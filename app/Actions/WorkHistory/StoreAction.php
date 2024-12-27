<?php

namespace App\Actions\WorkHistory;

use App\Actions\WorkHistory\BaseAction;
use App\Models\WorkHistory;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\WorkHistoryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreAction extends BaseAction
{
    use HasPerPageRequest;

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            /**
             * @var WorkHistory $workHistory
             */
            $workHistory = $this->workHistoryRepository->create($data);

            return $this->httpOK($workHistory, WorkHistoryTransformer::class);
        });
    }
}
