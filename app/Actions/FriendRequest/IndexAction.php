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
            $type = data_get(request()->all(), 'type', 'all');

            $query = $this->friendRequestRepository->queryBuilder()
                ->where('status', RequestFriendEnum::PENDING)
                ->whereNull('accepted_at');

            if ($type === 'sent') {
                $query->where('user_id', auth()->id());
            } else if ($type === 'received') {
                $query->where('friend_id', auth()->id());
            }

            $friendRequest = $query->paginate($this->getPerPage());

            return $this->httpOK($friendRequest, FriendRequestTransformer::class);
        });
    }
}
