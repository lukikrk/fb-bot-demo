<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use App\Messenger\Enum\QuestionIdEnum;

class OrderAddressStreet extends AbstractAnswer implements FacebookEventInterface
{
    public static function getQuestionId(): string
    {
        return QuestionIdEnum::ORDER_ADDRESS_STREET_QUESTION;
    }
}
