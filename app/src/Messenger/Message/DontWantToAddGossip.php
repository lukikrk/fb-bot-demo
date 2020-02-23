<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use App\Messenger\Enum\PayloadEnum;

final class DontWantToAddGossip extends AbstractFacebookQuickReplyPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = PayloadEnum::GOSSIP_DONT_WANT_TO_ADD;
}
