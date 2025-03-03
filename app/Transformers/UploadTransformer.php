<?php

namespace App\Transformers;

use App\Models\Upload;
use Flugg\Responder\Transformers\Transformer;

class UploadTransformer extends Transformer
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
     * @param  \App\Models\Upload $upload
     * @return array
     */
    public function transform(Upload $upload)
    {
        return [
            'id' => $upload->id,
            'name' => $upload->name ?? null,
            'link' => $upload->link ?? null,
            'type' => $upload->type ?? null,
        ];
    }
}
