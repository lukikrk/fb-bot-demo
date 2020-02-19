<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use Kerox\Messenger\Event\AbstractEvent;
use Kerox\Messenger\Event\PostbackEvent;

abstract class AbstractFacebookPostBack extends AbstractFacebookEvent
{
    use PayloadTrait;

    public function __construct(PostbackEvent $event)
    {
        parent::__construct($event);

        $this->payload = $event->getPostback()->getPayload();
    }

    public static function supports(AbstractEvent $event): bool
    {
        return $event instanceof PostbackEvent &&
            preg_match('/^'.static::$payloadPattern.'$/i', $event->getPostback()->getPayload());
    }
}
