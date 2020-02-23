<?php

declare(strict_types=1);

namespace App\Messenger\Collection;

use App\Messenger\Message\AddGossip;
use App\Messenger\Message\AddProductToCart;
use App\Messenger\Message\Gossips;
use App\Messenger\Message\Hello;
use App\Messenger\Message\DontWantToAddGossip;
use App\Messenger\Message\WantToAddGossip;
use App\Messenger\Message\MakeOrder;
use App\Messenger\Message\OrderAddressStreet;
use App\Messenger\Message\OrderAddressZip;
use App\Messenger\Message\PaymentMethod;
use App\Messenger\Message\Products;
use App\Messenger\Message\ShowCart;

class FacebookEventMessageCollection
{
    public static array $messages = [
        AddGossip::class,
        OrderAddressStreet::class,
        OrderAddressZip::class,
        Hello::class,
        Gossips::class,
        Products::class,
        WantToAddGossip::class,
        DontWantToAddGossip::class,
        AddProductToCart::class,
        ShowCart::class,
        MakeOrder::class,
        PaymentMethod::class,
    ];
}
