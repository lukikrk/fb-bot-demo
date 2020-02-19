<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class OrderAddressZip extends AbstractAnswer implements FacebookEventInterface
{
    public static function getQuestionId(): string
    {
        return 'ORDER_ADDRESS_ZIP_QUESTION';
    }
}
