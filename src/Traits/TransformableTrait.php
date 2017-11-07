<?php namespace Lessipe\Larabase\Traits;

/**
 * Class TransformableTrait
 * @package Lessipe\Larabase\Traits
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
