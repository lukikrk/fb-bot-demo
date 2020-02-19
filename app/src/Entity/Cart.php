<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart extends AbstractEntity
{
    private ?FacebookUser $user;

    private ?Order $order;

    private Collection $items;

    public function __construct(FacebookUser $user)
    {
        $this->user = $user;

        $this->items = new ArrayCollection();
    }

    public function update(?FacebookUser $user): void
    {
        $this->user = $user;
    }

    public function order(): ?Order
    {
        return $this->order;
    }

    /**
     * @return Collection | CartItem[]
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
