<?php

namespace App\Transformers;

use Flugg\Responder\Transformers\Transformer;

class CollectionTransform extends Transformer
{
    protected $relations = [];
    protected $load = [];

    public function transform($collection)
    {
        return collect($collection)->map(function ($items) {
            return $items->transform(fn($item) => 
                (new UploadTransformer)->transform($item)
            );
        })->toArray();
    }
}
