<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class IWantToAddGossip extends AbstractFacebookQuickReplyPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = 'GOSSIP_I_WANT_TO_ADD';
}
