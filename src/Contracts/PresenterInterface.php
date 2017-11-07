<?php
namespace Lessipe\Larabase\Contracts;

/**
 * Interface PresenterInterface
 * @package Lessipe\Larabase\Contracts
 */
interface PresenterInterface
{
    /**
     * Prepare data to present
     *
     * @param $data
     *
     * @return mixed
     */
    public function present($data);
}
