<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class ShowCart extends AbstractFacebookPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = 'SHOW-CART';
}
