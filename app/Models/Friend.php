<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friends';
    protected $fillable = [
        'user_id',
        'friend_id',
        'friend_type',
        'is_favorite',
        'blocked_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMyFriend(Builder $query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeYourFriend(Builder $query, int $id)
    {
        return $query->where('friend_id', $id);
    }
}
