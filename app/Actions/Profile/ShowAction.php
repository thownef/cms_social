<?php

namespace App\Actions\Profile;

use App\Actions\Profile\BaseAction;
use App\Models\Profile;
use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\ProfileTransformer;
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
            /**
             * @var Profile $profile
             */
            $profile = $this->profileRepository->find($id);

            return $this->httpOK($profile, ProfileTransformer::class);
        });
    }
}
