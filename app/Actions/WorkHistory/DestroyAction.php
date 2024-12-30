<?php

namespace App\Actions\WorkHistory;

use App\Actions\WorkHistory\BaseAction;
use App\Models\WorkHistory;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\WorkHistoryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DestroyAction extends BaseAction
{
    use HasPerPageRequest;

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        return DB::transaction(function () use ($id) {
            /**
             * @var WorkHistory $workHistory
             */
            $this->workHistoryRepository->delete($id);
            return $this->httpNoContent();
        });
    }
}
