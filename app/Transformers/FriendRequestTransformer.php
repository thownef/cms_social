<?php

namespace App\Transformers;

use App\Models\FriendRequest;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;

class FriendRequestTransformer extends Transformer
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
     * @param  \App\Models\FriendRequest $friendRequest
     * @return array
     */
    public function transform(FriendRequest $friendRequest)
    {
        $currentUserId = auth()->id();
        $isSender = $friendRequest->user_id === $currentUserId;

        return [
            'id' => $friendRequest->id,
            'created_at' => Carbon::parse($friendRequest->created_at)->format('Y/m/d H:i:s'),
            'user' => $isSender
                ? (new ProfileTransformer())->transform($friendRequest->sender->profile)
                : (new ProfileTransformer())->transform($friendRequest->receiver->profile)
        ];
    }
}
