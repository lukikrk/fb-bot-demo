<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\Hello;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class HelloHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    public function __invoke(Hello $helloMessage): void
    {
        $this->messenger->send()->action($helloMessage->sender(), Send::SENDER_ACTION_TYPING_ON);

        $this->messenger->send()->message($helloMessage->sender(),
            'Cześć ' . $this->messenger->user()->profile($helloMessage->sender())->getFirstName()
        );

        $this->messenger->send()->action($helloMessage->sender(), Send::SENDER_ACTION_TYPING_ON);

        $this->messenger->send()->message($helloMessage->sender(),
            'Czym mogę służyć? Chcesz zrobić zakupy czy interesują Cię plotki?'
        );
    }
}
