<?php

declare(strict_types=1);

namespace App\Messenger\Enum;

class PayloadEnum
{
    public const GREETING = 'GREETING';

    public const GOSSIP_WANT_TO_ADD = 'GOSSIP_WANT_TO_ADD';
    public const GOSSIP_DONT_WANT_TO_ADD = 'GOSSIP_DONT_WANT_TO_ADD';

    public const SHOW_CART = 'SHOW-CART';
    public const CART_ADD_PRODUCT = 'CART-ADD-%s';

    public const MAKE_ORDER = 'MAKE-ORDER';
}
