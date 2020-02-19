<?php

declare(strict_types=1);

namespace App\Factory;

use App\Messenger\Collection\FacebookEventMessageCollection;
use App\Messenger\Message\DoNotUnderstand;
use App\Messenger\Message\FacebookEventInterface;
use App\Service\FacebookUserService;
use Kerox\Messenger\Event\AbstractEvent;

class FacebookMessageFactory
{
    private FacebookUserService $facebookUserService;

    public function __construct(FacebookUserService $facebookUserService)
    {
        $this->facebookUserService = $facebookUserService;
    }

    public function createByFacebookEvent(AbstractEvent $event): FacebookEventInterface
    {
        $params = ($questionId = $this->facebookUserService->obtain($event->getSenderId())->questionId())
            ? [$event, $questionId] : [$event];

        foreach (FacebookEventMessageCollection::$messages as $message) {
            if (call_user_func($message.'::supports', ...$params)) {
                return new $message($event);
            }
        }

        return new DoNotUnderstand($event);
    }
}
