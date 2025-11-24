<?php

namespace App\Actions\Friend;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\FriendSuggestionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SuggestAction extends BaseAction
{
    use HasPerPageRequest;

    public function __invoke(): JsonResponse
    {
        return DB::transaction(function () {
            $suggestions = $this->userRepository->suggestedFriends()->paginate($this->getPerPage());

            return $this->httpOK($suggestions, FriendSuggestionTransformer::class);
        });
    }
}
