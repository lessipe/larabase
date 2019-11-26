<?php

namespace Lessipe\Larabase\Contracts;

use Illuminate\Support\MessageBag;

class Exception extends \Exception
{
    /**
     * @var MessageBag | null
     */
    private $messageBag = null;

    /**
     * @param MessageBag $messageBag
     */
    public function setMessageBag(MessageBag $messageBag)
    {
        $this->messageBag = $messageBag;
    }

    /**
     * @return MessageBag|null
     */
    public function getMessageBag()
    {
        return $this->messageBag;
    }
}
