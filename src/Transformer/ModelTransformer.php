<?php namespace Lessipe\Larabase\Transformer;

use League\Fractal\TransformerAbstract;
use Lessipe\Larabase\Contracts\Transformable;

/**
 * Class ModelTransformer
 * @package Lessipe\Larabase\Transformer
 */
class ModelTransformer extends TransformerAbstract
{
    public function transform(Transformable $model)
    {
        return $model->transform();
    }
}
