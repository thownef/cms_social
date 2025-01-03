<?php

namespace App\Actions\FriendRequest;

use App\Enums\RequestFriendEnum;
use App\Transformers\FriendRequestTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateAction extends BaseAction
{
    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(int $id, array $data): JsonResponse
    {
        return DB::transaction(function () use ($id, $data) {
            $status = data_get($data, 'status');
            $data['accepted_at'] = (int) $status === RequestFriendEnum::ACCEPTED ? now() : null;
            $friendRequest = $this->friendRequestRepository->update($data, $id);
            return $this->httpOK($friendRequest, FriendRequestTransformer::class);
        });
    }
}
