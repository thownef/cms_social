<?php

namespace App\Actions\Friend;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\FriendTransformer;
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
            $friend = $this->friendRepository->myFriend()->paginate($this->getPerPage());

            return $this->httpOK($friend, FriendTransformer::class);
        });
    }
}
