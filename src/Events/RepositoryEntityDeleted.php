<?php
namespace Visualplus\Larabase\Events;

/**
 * Class RepositoryEntityDeleted
 * @package Visualplus\Larabase\Events
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
