<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use Kerox\Messenger\Event\AbstractEvent;

final class DoNotUnderstand extends AbstractFacebookEvent implements FacebookEventInterface
{
    public static function supports(AbstractEvent $event): bool
    {
        return true;
    }
}
