<?php

declare(strict_types=1);

namespace App\Messenger\Message;

use Kerox\Messenger\Event\AbstractEvent;
use Kerox\Messenger\Event\MessageEvent;

abstract class AbstractAnswer extends AbstractFacebookMessage implements AnswerInterface
{
    public static function supports(AbstractEvent $event, ?string $questionId = null): bool
    {
        if (null === $questionId) {
            return false;
        }

        return $event instanceof MessageEvent &&
            preg_match('/^'.static::getQuestionId().'$/i', $questionId);
    }
}
