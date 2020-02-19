<?php

declare(strict_types=1);

namespace App\Messenger\Message;

interface AnswerInterface
{
    public static function getQuestionId(): string;
}
