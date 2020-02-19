<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use Kerox\Messenger\Event\AbstractEvent;
use Kerox\Messenger\Event\MessageEvent;

abstract class AbstractFacebookMessage extends AbstractFacebookEvent
{
    protected static array $keywords = [];

    protected string $content;

    public function __construct(MessageEvent $event)
    {
        parent::__construct($event);

        $this->content = $event->getMessage()->getText();
    }

    public function content(): string
    {
        return $this->content;
    }

    public static function supports(AbstractEvent $event): bool
    {
        return $event instanceof MessageEvent &&
            preg_match('/^'.implode('|', static::$keywords).'$/i', $event->getMessage()->getText());
    }
}
