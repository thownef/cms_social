<?php

namespace App\Actions\FriendRequest;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\FriendRequestTransformer;
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
            $friendRequest = $this->friendRequestRepository->create($data);
            return $this->httpOK($friendRequest->fresh(), FriendRequestTransformer::class);
        });
    }
}
