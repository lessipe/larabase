<?php

/**
 * @param \Visualplus\Larabase\Action\BaseAction $action
 */
function perform(\Visualplus\Larabase\Action\BaseAction $action)
{
    app(\Visualplus\Larabase\Action\ActionPerformer::class)->perform($action);
}