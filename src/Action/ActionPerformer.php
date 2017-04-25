<?php

namespace Visualplus\Larabase\Action;

use DB;

class ActionPerformer
{
    /**
     * @param BaseAction $action
     */
    public function perform(BaseAction $action)
    {
        DB::beginTransaction();

        foreach ($action->getJobs() as $job) {
            $performedData = dispatch(new $job($action));

            $action->addPerformedData($job, $performedData);
        }

        DB::commit();
    }
}