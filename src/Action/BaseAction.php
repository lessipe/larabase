<?php

namespace Visualplus\Larabase\Action;

abstract class BaseAction
{
    /**
     * @var array
     */
    private $performedData = [];

    /**
     * @param $tag
     * @param $data
     * @return void
     */
    public function addPerformedData($tag, $data)
    {
        $this->performedData[$tag] = $data;
    }

    /**
     * @return array
     */
    abstract public function getTransactionalJobs();

    /**
     * @return array
     */
    abstract public function getFinishJobs();

    /**
     * @return mixed
     */
    abstract public function getDefaultOutput();
}