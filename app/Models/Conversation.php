<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    protected $table = 'conversations';
    protected $fillable = [
        'user_id1',
        'user_id2',
        'last_message_id'
    ];

    public function lastMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    public function users1()
    {
        return $this->belongsTo(User::class, 'user_id1');
    }

    public function users2()
    {
        return $this->belongsTo(User::class, 'user_id2');
    }
}
