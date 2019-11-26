<?php


namespace Lessipe\Larabase\Contracts;

use Illuminate\Support\Facades\Gate;
use Lessipe\Larabase\Exceptions\UnauthorizedException;

abstract class Job
{
    /**
     * @param $target
     * @param string $rule
     * @throws UnauthorizedException
     */
    protected function authorize($target, $rule = 'create'): void
    {
        if (Gate::denies($rule, $target)) {
            throw new UnauthorizedException();
        }
    }
}
