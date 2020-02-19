<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class IDoNotWantToAddGossip extends AbstractFacebookQuickReplyPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = 'GOSSIP_I_DO_NOT_WANT_TO_ADD';
}
