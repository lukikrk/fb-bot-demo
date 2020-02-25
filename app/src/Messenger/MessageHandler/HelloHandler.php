<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\Hello;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class HelloHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    public function __invoke(Hello $message): void
    {
        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);

        $this->messenger->send()->message($message->sender(),
            'Cześć ' . $this->messenger->user()->profile($message->sender())->getFirstName() . " 👋"
        );

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);

        $this->messenger->send()->message($message->sender(),
            'Czym mogę służyć? Chcesz zrobić zakupy 🛒 czy interesują Cię plotki? 🗣'
        );
    }
}
