<?php

declare(strict_types=1);

namespace App\Entity;

class Product extends AbstractEntity
{
    private string $name;

    private string $imageUrl;

    private float $price;

    public function __construct(string $name, string $imageUrl, float $price)
    {
        $this->name = $name;
        $this->imageUrl = $imageUrl;
        $this->price = $price;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }

    public function price(): float
    {
        return $this->price;
    }
}
