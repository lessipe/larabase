<?php

namespace Visualplus\Larabase\Service;

use Illuminate\Validation\UnauthorizedException;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\LaravelValidator;
use Gate;

abstract class BaseService
{
    /**
     * @param array $data
     * @param string $rule
     * @throws ValidatorException
     */
    protected function validate(array $data, $rule)
    {
        $validator = $this->getValidator();

        if (! $validator->with($data)->passes($rule)) {
            throw new ValidatorException($validator->errorsBag());
        }
    }

    /**
     * @param $target
     * @param string $rule
     * @throws UnauthorizedException
     * @return void
     */
    protected function authorize($target, $rule = 'create')
    {
        if (Gate::denies($target, $rule)) {
            throw new UnauthorizedException();
        }
    }

    /**
     * @return LaravelValidator
     */
    abstract protected function getValidator();
}