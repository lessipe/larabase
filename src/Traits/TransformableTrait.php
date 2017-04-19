<?php namespace Visualplus\Larabase\Traits;

/**
 * Class TransformableTrait
 * @package Visualplus\Larabase\Traits
 */
trait TransformableTrait
{

    /**
     * @return array
     */
    public function transform()
    {
        return $this->toArray();
    }
}
