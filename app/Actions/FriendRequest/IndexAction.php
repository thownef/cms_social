<?php

namespace App\Actions\FriendRequest;

use App\Enums\RequestFriendEnum;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\FriendRequestTransformer;
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
            $friendRequest = $this->friendRequestRepository->queryBuilder()
                ->where('status', RequestFriendEnum::PENDING)
                ->whereNull('accepted_at')
                ->paginate($this->getPerPage());

            return $this->httpOK($friendRequest, FriendRequestTransformer::class);
        });
    }
}
