<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use Kerox\Messenger\Event\AbstractEvent;

abstract class AbstractFacebookEvent
{
    private string $sender;

    public function __construct(AbstractEvent $event)
    {
        $this->sender = $event->getSenderId();
    }

    public function sender(): string
    {
        return $this->sender;
    }
}
