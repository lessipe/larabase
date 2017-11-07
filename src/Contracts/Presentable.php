<?php
namespace Lessipe\Larabase\Contracts;

/**
 * Interface Presentable
 * @package Lessipe\Larabase\Contracts
 */
interface Presentable
{
    /**
     * @param PresenterInterface $presenter
     *
     * @return mixed
     */
    public function setPresenter(PresenterInterface $presenter);

    /**
     * @return mixed
     */
    public function presenter();
}
