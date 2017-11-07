<?php
namespace Lessipe\Larabase\Events;

/**
 * Class RepositoryEntityDeleted
 * @package Lessipe\Larabase\Events
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
