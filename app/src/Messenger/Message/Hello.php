<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class Hello extends AbstractFacebookMessage implements FacebookEventInterface
{
    protected static array $keywords = ['Cześć'];
}
