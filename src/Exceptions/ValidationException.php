<?php


namespace Lessipe\Larabase\Exceptions;

use Illuminate\Support\MessageBag;
use Throwable;
use Lessipe\Larabase\Contracts\Exception;

class ValidationException extends Exception
{
    /**
     * ValidationException constructor.
     * @param MessageBag $messageBag
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(MessageBag $messageBag, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->setMessageBag($messageBag);
    }
}
