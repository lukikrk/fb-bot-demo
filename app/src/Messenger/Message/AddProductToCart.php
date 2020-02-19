<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class AddProductToCart extends AbstractFacebookPostBack implements FacebookEventInterface
{
    protected static string $payloadPattern = 'CART-ADD-(?<productId>\d+)';
}
