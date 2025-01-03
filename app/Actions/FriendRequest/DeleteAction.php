<?php

namespace App\Actions\FriendRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteAction extends BaseAction
{
    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        return DB::transaction(function () use ($id) {
            $this->friendRequestRepository->delete($id);
            return $this->httpNoContent();
        });
    }
}

