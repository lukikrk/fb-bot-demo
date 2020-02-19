<?php

declare(strict_types=1);

namespace App\Messenger\Message;

class OrderAddressStreet extends AbstractAnswer implements FacebookEventInterface
{
    public static function getQuestionId(): string
    {
        return 'ORDER_ADDRESS_STREET_QUESTION';
    }
}
