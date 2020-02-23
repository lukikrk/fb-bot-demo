<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use App\Messenger\Enum\QuestionIdEnum;

final class AddGossip extends AbstractAnswer implements FacebookEventInterface
{
    public static function getQuestionId(): string
    {
        return QuestionIdEnum::ADD_GOSSIP_QUESTION;
    }
}
