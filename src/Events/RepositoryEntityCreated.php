<?php
namespace Lessipe\Larabase\Events;

/**
 * Class RepositoryEntityCreated
 * @package Lessipe\Larabase\Events
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "created";
}
