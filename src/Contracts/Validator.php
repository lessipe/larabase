<?php

namespace Lessipe\Larabase\Contracts;

use Illuminate\Support\Facades\Validator as LaravelValidator;
use Lessipe\Larabase\Exceptions\ValidationException;

abstract class Validator
{
    /**
     * @param $type
     * @return array
     */
    abstract protected function getValidationRule($type): array;

    /**
     * @param $type
     * @return array
     */
    abstract protected function getMessages($type): array;

    /**
     * @param $type
     * @return array
     */
    abstract protected function getCustomAttributes($type): array;

    /**
     * @param $data
     * @param $type
     * @throws ValidationException
     */
    public function validate($data, $type): void
    {
        $validator = LaravelValidator::make($data,
            $this->getValidationRule($type),
            $this->getMessages($type),
            $this->getCustomAttributes($type)
        );

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }
    }
}
