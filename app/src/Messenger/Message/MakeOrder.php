<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class MakeOrder extends AbstractFacebookPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = 'MAKE-ORDER';
}
