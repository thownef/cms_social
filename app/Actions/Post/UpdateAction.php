<?php

namespace App\Actions\Post;

use App\Actions\Post\BaseAction;
use App\Models\Post;
use App\Transformers\PostTransformer;
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
            /**
             * @var Post $post
             */
            $post = $this->postRepository->find($id);
            
            $file_ids = data_get($data, 'file_ids', []);
            if (!empty($file_ids)) {
                $post->uploadable()
                    ->whereIn('id', $file_ids)
                    ->get()
                    ->each(function ($upload) {
                        $upload->delete();
                    });
            }

            $post = $this->postRepository->update($data, $id);
            $files = data_get($data, 'files', []);
            if (!empty($files)) {
                $this->executeUpload($post, $files);
            }

            return $this->httpOK($post->fresh(), PostTransformer::class);
        });
    }
}