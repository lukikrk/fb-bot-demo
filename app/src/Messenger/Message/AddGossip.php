<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class AddGossip extends AbstractAnswer implements FacebookEventInterface
{
    public static function getQuestionId(): string
    {
        return 'ADD_GOSSIP_QUESTION';
    }
}
