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
        $userId = request()->get('filter')['user_id'] ?? null;
        $friendId = request()->get('filter')['friend_id'] ?? null;
        if (is_null($userId) && is_null($friendId)) {
            return [
                'id' => $friendRequest->id,
                'user_id' => $friendRequest->user_id,
                'friend_id' => $friendRequest->friend_id,
                'status' => $friendRequest->status,
                'created_at' => Carbon::parse($friendRequest->created_at)->format('Y/m/d H:i:s'),
                'updated_at' => Carbon::parse($friendRequest->updated_at)->format('Y/m/d H:i:s'),
            ];
        } else {
            $result = [];
            
            if ($userId) {
                $result = (new ProfileTransformer())->transform($friendRequest->receiver->profile);
            }
            
            if ($friendId) {
                $result = (new ProfileTransformer())->transform($friendRequest->sender->profile);
            }

            return $result;
        }
    }
}
