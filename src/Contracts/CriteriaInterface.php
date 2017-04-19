<?php
namespace Visualplus\Larabase\Contracts;

/**
 * Interface CriteriaInterface
 * @package Visualplus\Larabase\Contracts
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
