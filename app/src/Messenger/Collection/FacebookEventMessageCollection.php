<?php

declare(strict_types=1);

namespace App\Messenger\Collection;

use App\Messenger\Message\AddGossip;
use App\Messenger\Message\AddProductToCart;
use App\Messenger\Message\Gossips;
use App\Messenger\Message\Hello;
use App\Messenger\Message\IDoNotWantToAddGossip;
use App\Messenger\Message\IWantToAddGossip;
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
        IWantToAddGossip::class,
        IDoNotWantToAddGossip::class,
        AddProductToCart::class,
        ShowCart::class,
        MakeOrder::class,
        PaymentMethod::class,
    ];
}
