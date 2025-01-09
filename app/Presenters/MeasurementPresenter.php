<?php

namespace App\Presenters;

use App\Transformers\MeasurementTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MeasurementPresenter.
 *
 * @package namespace App\Presenters;
 */
class MeasurementPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return TransformerAbstract
     */
    public function getTransformer(): MeasurementTransformer|TransformerAbstract
    {
        return new MeasurementTransformer();
    }
}
