<?php

declare(strict_types=1);

namespace App\Entity;

abstract class AbstractEntity
{
    protected int $id;

    public function id(): int
    {
        return $this->id;
    }
}
