<?php

namespace App\Actions\Message;

use App\Repositories\Traits\HasPerPageRequest;
use App\Transformers\MessagesTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class IndexAction extends BaseAction
{
    use HasPerPageRequest;

    public function __invoke(): JsonResponse
    {
        return DB::transaction(function () {
            $messages = $this->messageRepository->queryBuilder()->paginate($this->getPerPage());
            $meta = [
                'next_cursor' => $messages->items() ? last($messages->items())->created_at->toDateTimeString() : null,
                'has_more' => $messages->hasMorePages()
            ];

            return $this->httpOK($messages, MessagesTransformer::class, meta: $meta);
        });
    }
}
