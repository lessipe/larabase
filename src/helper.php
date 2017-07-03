<?php

if (! function_exists('perform')) {
    /**
     * @param \Visualplus\Larabase\Action\BaseAction $action
     */
    function perform(\Visualplus\Larabase\Action\BaseAction $action)
    {
        return app(\Visualplus\Larabase\Action\ActionPerformer::class)->perform($action);
    }
}