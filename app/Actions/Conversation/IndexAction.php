<?php

namespace App\Actions\Conversation;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\ConversationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class IndexAction extends BaseAction
{
    use HasPerPageRequest;

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return DB::transaction(function () {
            $conversations = $this->conversationRepository->whereHas('participants', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->paginate($this->getPerPage());

            return $this->httpOK($conversations, ConversationTransformer::class);
        });
    }
}
