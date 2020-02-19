<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use Kerox\Messenger\Event\AbstractEvent;
use Kerox\Messenger\Event\MessageEvent;

abstract class AbstractFacebookQuickReplyPostBack extends AbstractFacebookEvent
{
    use PayloadTrait;

    public function __construct(MessageEvent $event)
    {
        parent::__construct($event);

        $this->payload = $event->getMessage()->getQuickReply();
    }

    public static function supports(AbstractEvent $event): bool
    {
        return $event instanceof MessageEvent && $event->getMessage()->getQuickReply() &&
            preg_match('/^'.static::$payloadPattern.'$/i', $event->getMessage()->getQuickReply());
    }
}
