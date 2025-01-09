<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Measurement;

/**
 * Class MeasurementTransformer.
 *
 * @package namespace App\Transformers;
 */
class MeasurementTransformer extends TransformerAbstract
{


    public function transform(Measurement $model): array
    {
        return [
            'id' => (int) $model->id,
            'name'  => $model->name,
        ];
    }
}
