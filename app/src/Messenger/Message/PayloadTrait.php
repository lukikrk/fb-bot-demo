<?php

declare(strict_types=1);

namespace App\Messenger\Message;

trait PayloadTrait
{
    protected static string $payloadPattern = '';

    protected string $payload = '';

    public function getPayloadParam(string $paramName): ?string
    {
        preg_match('/'.static::$payloadPattern.'/', $this->payload, $matches);

        return $matches[$paramName] ?? null;
    }
}
