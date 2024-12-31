<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\HasUploadMultiple;
use App\Models\Traits\HasUserContext;

class Post extends Model
{
    use HasFactory, HasUploadMultiple, HasUserContext;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'content',
        'is_public'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
