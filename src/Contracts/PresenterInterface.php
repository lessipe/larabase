<?php
namespace Visualplus\Larabase\Contracts;

/**
 * Interface PresenterInterface
 * @package Visualplus\Larabase\Contracts
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
