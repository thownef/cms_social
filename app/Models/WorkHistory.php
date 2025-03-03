<?php

namespace App\Models;

use App\Models\Traits\HasProfileContext;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkHistory extends Model
{
    use HasFactory, HasProfileContext;

    protected $table = 'work_histories';
    protected $fillable = [
        'profile_id', 
        'job_title', 
        'company_name', 
        'location',
        'date_started', 
        'date_ended', 
        'is_current',
        'is_public'
    ];

    protected $casts = [
        'date_started' => 'date',
        'date_ended' => 'date',
        'is_current' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
