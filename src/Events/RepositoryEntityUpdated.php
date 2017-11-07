<?php
namespace Lessipe\Larabase\Events;

/**
 * Class RepositoryEntityUpdated
 * @package Lessipe\Larabase\Events
 */
class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updated";
}
