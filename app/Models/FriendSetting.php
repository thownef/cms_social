<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendSetting extends Model
{
    use HasFactory;

    protected $table = 'friend_settings';
    protected $fillable = [
        'user_id',
        'show_friendship',
        'show_posts',
    ];

    protected $casts = [
        'show_friendship' => 'boolean',
        'show_posts' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
