<?php

declare(strict_types=1);

namespace App\Entity;

class CartItem extends AbstractEntity
{
    private Cart $cart;

    private Product $product;

    private int $quantity;

    public function __construct(Cart $cart, Product $product, int $quantity = 1)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function totalPrice(): float
    {
        return $this->product->price() * $this->quantity;
    }
}
