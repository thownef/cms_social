<?php

namespace App\Transformers;

use App\Models\Conversation;
use Flugg\Responder\Transformers\Transformer;

class ConversationTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = ['participants', 'group'];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Conversation $conversation
     * @return array
     */
    public function transform(Conversation $conversation)
    {
        switch ($conversation->is_group) {
            case true:
                $participant = [
                    'name' => $conversation->group->name,
                    'avatar' => $conversation->group->avatar,
                ];
                break;
            case false:
                $participant = $conversation->participants->where('id', '!=', auth()->id())
                    ->map(function ($participant) {
                        return [
                            'user_id' => $participant->id,
                            'name' => $participant->profile->first_name . ' ' . $participant->profile->last_name,
                            'avatar' => $participant->profile->avatar,
                        ];
                    })->first();
                break;
        }
        return [
            'id' => $conversation->id,
            'group_id' => $conversation->group_id,
            'is_group' => $conversation->is_group,
            'last_message' => $conversation->lastMessage->message,
            'last_message_at' => $conversation->lastMessage->created_at,
            ...$participant,
            'created_at' => $conversation->created_at,
            'updated_at' => $conversation->updated_at,
        ];
    }
}
