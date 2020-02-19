<?php

declare(strict_types=1);

namespace App\Entity;

class Order extends AbstractEntity
{
    private FacebookUser $user;

    private Cart $cart;

    private ?OrderAddress $orderAddress;

    private ?PaymentMethod $paymentMethod;

    public function __construct(FacebookUser $user, Cart $cart)
    {
        $this->user = $user;
        $this->cart = $cart;
    }

    public function update(?OrderAddress $orderAddress, ?PaymentMethod $paymentMethod)
    {
        $this->orderAddress = $orderAddress;
        $this->paymentMethod = $paymentMethod;
    }

    public function orderAddress(): ?OrderAddress
    {
        return $this->orderAddress;
    }

    public function paymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function totalPrice(): float
    {
        $total = 0;

        foreach ($this->cart->items() as $item) {
            $total += $item->totalPrice();
        }

        return $total;
    }
}
