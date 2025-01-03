<?php

namespace App\Actions\Friend;

use App\Repositories\FriendSettingRepository;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\FriendTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ShowAction extends BaseAction
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
            $friendSettingRepository = resolve(FriendSettingRepository::class);
            $friendSetting = $friendSettingRepository->find($id);
            if($friendSetting->show_friendship) {
                $friend = $this->friendRepository->yourFriend($id)->paginate($this->getPerPage());
            } else {
                return $this->httpOK([]);
            }
            return $this->httpOK($friend, FriendTransformer::class);
        });
    }
}
