<?php

namespace App\Transformers;

use App\Models\Friend;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;

class FriendTransformer extends Transformer
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
     * @param  \App\Models\Friend $friend
     * @return array
     */
    public function transform(Friend $friend)
    {
        return (new ProfileTransformer())->transform($friend->user->profile);
    }
}

