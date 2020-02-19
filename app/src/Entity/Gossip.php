<?php

declare(strict_types=1);

namespace App\Entity;

class Gossip extends AbstractEntity
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function text(): string
    {
        return $this->text;
    }
}
