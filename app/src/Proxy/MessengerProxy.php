<?php

declare(strict_types=1);

namespace App\Proxy;

use Kerox\Messenger\Messenger;

class MessengerProxy
{
    private Messenger $messenger;

    public function __construct()
    {
        $this->messenger = new Messenger(
            $_ENV['FACEBOOK_SECRET'],
            $_ENV['VERIFY_TOKEN'],
            $_ENV['PAGE_ACCESS_TOKEN'],
        );
    }

    public function messenger(): Messenger
    {
        return $this->messenger;
    }
}
