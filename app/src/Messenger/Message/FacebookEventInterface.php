<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use Kerox\Messenger\Event\AbstractEvent;

interface FacebookEventInterface
{
    public function sender(): string;

    public static function supports(AbstractEvent $event): bool;
}
