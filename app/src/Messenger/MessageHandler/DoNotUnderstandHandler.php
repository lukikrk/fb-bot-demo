<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\DoNotUnderstand;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DoNotUnderstandHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    public function __invoke(DoNotUnderstand $doNotUnderstandMessage): void
    {
        $this->messenger->send()->action($doNotUnderstandMessage->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message(
            $doNotUnderstandMessage->sender(),
            'Przykro mi, ale nie rozumiem :('
        );
    }
}
