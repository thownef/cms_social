<?php

namespace App\Transformers;

use App\Models\User;
use Flugg\Responder\Transformers\Transformer;

class FriendSuggestionTransformer extends Transformer
{
    protected $relations = ['profile'];
    protected $load = [];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'mutual_friends_count' => (int) ($user->mutual_friends_count ?? 0),
            'profile' => $user->profile ? (new ProfileTransformer())->transform($user->profile) : null,
        ];
    }
}

