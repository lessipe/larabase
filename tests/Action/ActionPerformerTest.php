<?php

namespace Action;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Visualplus\Larabase\Action\ActionPerformer;
use Visualplus\Larabase\Action\BaseAction;

class ActionPerformerTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();

        m::close();
    }

    public function test_do_not_commit_if_an_error_is_thrown()
    {
        $dispatcher = $this->getDispatcherMock();
        $databaseManager = $this->getDatabaseManagerMock(false);
        $action = $this->getBaseActionMock();

        $action->shouldReceive('getTransactionalJobs')
            ->once()
            ->andThrow(\Exception::class);

        $this->expectException(\Exception::class);

        $this->perform($dispatcher, $databaseManager, $action);
    }

    public function test_commit_if_perform_finished()
    {
        $dispatcher = $this->getDispatcherMock();
        $databaseManager = $this->getDatabaseManagerMock();
        $action = $this->getBaseActionMock();

        $action->shouldReceive('getTransactionalJobs')
            ->once()
            ->andReturn([]);

        $action->shouldReceive('getFinishJobs')
            ->once()
            ->andReturn([]);

        $this->perform($dispatcher, $databaseManager, $action);
    }

    public function test_do_not_end_even_finish_job_thrown_an_error()
    {
        $dispatcher = $this->getDispatcherMock();
        $databaseManager = $this->getDatabaseManagerMock();
        $action = $this->getBaseActionMock();

        $action->shouldReceive('getTransactionalJobs')
            ->once()
            ->andReturn([]);

        $action->shouldReceive('getFinishJobs')
            ->once()
            ->andReturn([
                FinishJob::class
            ]);

        $dispatcher->shouldReceive('dispatch')
            ->with(FinishJob::class)
            ->andThrow(\Exception::class);

        $this->perform($dispatcher, $databaseManager, $action);
    }

    public function test_store_data_after_dispatch_transactional_job()
    {
        $dispatcher = $this->getDispatcherMock();
        $databaseManager = $this->getDatabaseManagerMock();
        $action = $this->getBaseActionMock();

        $dispatcher->shouldReceive('dispatchNow')
            ->once()
            ->andReturn('test job succeed!');

        $action->shouldReceive('getTransactionalJobs')
            ->once()
            ->andReturn([
                TransactionalJob::class
            ]);

        $action->shouldReceive('getFinishJobs')
            ->once()
            ->andReturn([]);

        $action->shouldReceive('addPerformedData')
                ->with(TransactionalJob::class, 'test job succeed!')
                ->once();

        $this->perform($dispatcher, $databaseManager, $action);
    }

    /**
     * @param bool $transaction
     * @return m\MockInterface
     */
    private function getDatabaseManagerMock($transaction = true)
    {
        $connection = m::mock(Connection::class);
        $databaseManager = m::mock(DatabaseManager::class);

        $connection->shouldReceive('beginTransaction')
            ->once();

        if ($transaction) {
            $connection->shouldReceive('commit')
                ->once();
        }

        $databaseManager
            ->shouldReceive('connection')
            ->andReturn($connection);
        return $databaseManager;
    }

    /**
     * @param $dispatcher
     * @param $databaseManager
     * @param $action
     */
    private function perform($dispatcher, $databaseManager, $action)
    {
        $performer = new ActionPerformer($dispatcher, $databaseManager);
        $performer->perform($action);
    }

    /**
     * @return m\MockInterface
     */
    private function getDispatcherMock()
    {
        $dispatcher = m::mock(Dispatcher::class);
        return $dispatcher;
    }

    /**
     * @return m\MockInterface
     */
    private function getBaseActionMock()
    {
        $action = m::mock(BaseAction::class);
        return $action;
    }
}

class TransactionalJob
{
    private $action;

    public function __construct(BaseAction $action)
    {
        $this->action = $action;
    }

    public function handle()
    {
        return 'test job succeed!';
    }
}

class FinishJob
{
    private $action;

    public function __construct(BaseAction $action)
    {
        $this->action = $action;
    }

    public function handle()
    {
        return 'finish job succeed!';
    }
}