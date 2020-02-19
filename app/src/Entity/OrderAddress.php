<?php

declare(strict_types=1);

namespace App\Entity;

class OrderAddress extends AbstractEntity
{
    private string $street;

    private ?string $zip;

    public function __construct(string $street)
    {
        $this->street = $street;
    }

    public function update(string $zip): void
    {
        $this->zip = $zip;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function zip(): string
    {
        return $this->zip;
    }
}
