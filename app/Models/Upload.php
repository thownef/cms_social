<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upload extends Model
{
    use HasFactory;

    protected $table = 'uploads';

    protected $fillable = ['uploadable_id', 'uploadable_type', 'name', 'link'];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function uploadable(): MorphTo
    {
        return $this->morphTo();
    }
}
