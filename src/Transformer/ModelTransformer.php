<?php namespace Visualplus\Larabase\Transformer;

use League\Fractal\TransformerAbstract;
use Visualplus\Larabase\Contracts\Transformable;

/**
 * Class ModelTransformer
 * @package Visualplus\Larabase\Transformer
 */
class ModelTransformer extends TransformerAbstract
{
    public function transform(Transformable $model)
    {
        return $model->transform();
    }
}
