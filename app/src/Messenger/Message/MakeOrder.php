<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use App\Messenger\Enum\PayloadEnum;

final class MakeOrder extends AbstractFacebookPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = PayloadEnum::MAKE_ORDER;
}
