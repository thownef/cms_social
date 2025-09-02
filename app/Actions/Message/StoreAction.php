<?php

namespace App\Actions\Message;

use App\Actions\Message\BaseAction;
use App\Events\MessageSent;
use App\Transformers\MessagesTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreAction extends BaseAction
{
    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @return JsonResponse
     */
    public function __invoke(array $data): JsonResponse
    {
        return DB::transaction(function () use ($data) {
            /**
             * @var \App\Models\Message $message
             */
            $message = $this->messageRepository->create($data);

            broadcast(new MessageSent($message))->toOthers();

            return $this->httpOK($message, MessagesTransformer::class);
        });
    }
}
