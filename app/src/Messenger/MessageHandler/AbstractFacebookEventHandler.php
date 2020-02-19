<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Proxy\MessengerProxy;
use Kerox\Messenger\Messenger;

abstract class AbstractFacebookEventHandler
{
    protected Messenger $messenger;

    public function __construct(MessengerProxy $messengerProxy)
    {
        $this->messenger = $messengerProxy->messenger();
    }
}
