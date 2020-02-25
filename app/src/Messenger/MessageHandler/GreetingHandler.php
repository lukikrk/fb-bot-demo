<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\Greeting;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GreetingHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    public function __invoke(Greeting $message)
    {
        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);

        $this->messenger->send()->message($message->sender(),
            'Cześć ' . $this->messenger->user()->profile($message->sender())->getFirstName() . "👋"
        );

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);

        $this->messenger->send()->message($message->sender(),
            'Czym mogę służyć? Chcesz zrobić zakupy 🛒 czy interesują Cię plotki? 🗣'
        );
    }
}
