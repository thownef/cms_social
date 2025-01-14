<?php

namespace App\Transformers;

use App\Models\Post;
use Carbon\Carbon;
use Flugg\Responder\TransformBuilder;
use Flugg\Responder\Transformers\Transformer;

class PostTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'content' => $post->content,
            'is_public' => $post->is_public,
            'created_at' => Carbon::parse($post->created_at)->format('Y/m/d H:i:s'),
            'updated_at' => Carbon::parse($post->updated_at)->format('Y/m/d H:i:s'),
            'file' => app(TransformBuilder::class)
                ->resource($post->uploadable, new UploadTransformer())
                ->transform()['data'] ?? [],
            'created_by' => [
                'id' => $post->user->id,
                'first_name' => $post->user->profile->first_name,
                'last_name' => $post->user->profile->last_name,
                'avatar' => $post->user->profile->avatar
                    ? (new UploadTransformer)->transform($post->user->profile->avatar)
                    : null,
            ],
        ];
    }
}
