<?php

namespace App\Actions\Profile;

use App\Actions\Profile\BaseAction;
use App\Repositories\PostRepository;
use App\Transformers\PostTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UploadImageAction extends BaseAction
{

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(int $id, array $data): JsonResponse
    {
        return DB::transaction(function () use ($id, $data) {
            $profile = $this->profileRepository->find($id);
            $post = $this->postRepository->create($data);

            $file = data_get($data, 'file');
            $type = data_get($data, 'type', 'avatar');

            $this->executeUpload($post, $file, $type);

            $postUpload = $post->uploadable()->first();

            if ($postUpload) {
                $this->executeUploadImage($profile, $postUpload, $type);
            }

            return $this->httpOK($post, new PostTransformer);
        });
    }
}
