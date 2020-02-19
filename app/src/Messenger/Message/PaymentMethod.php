<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class PaymentMethod extends AbstractFacebookQuickReplyPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = 'PAYMENT-METHOD-(?<paymentMethodId>\d+)';
}
