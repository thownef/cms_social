<?php

namespace App\Transformers;

use App\Models\WorkHistory;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;

class WorkHistoryTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\WorkHistory $workHistory
     * @return array
     */
    public function transform(WorkHistory $workHistory)
    {
        return [
            'id' => $workHistory->id,
            'profile_id' => $workHistory->profile_id,
            'job_title' => $workHistory->job_title,
            'company_name' => $workHistory->company_name,
            'location' => $workHistory->location,
            'date_started' => $workHistory->date_started,
            'date_ended' => $workHistory->date_ended,
            'is_current' => $workHistory->is_current,
            'is_public' => $workHistory->is_public,
            'created_at' => Carbon::parse($workHistory->created_at)->format('Y/m/d H:i:s'),
            'updated_at' => Carbon::parse($workHistory->updated_at)->format('Y/m/d H:i:s'),
        ];
    }
}
