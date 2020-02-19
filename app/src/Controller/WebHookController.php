<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\FacebookMessageFactory;
use App\Messenger\Message\Hello;
use App\Proxy\MessengerProxy;
use Kerox\Messenger\Event\AbstractEvent;
use Kerox\Messenger\Messenger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/webhook")
 */
class WebHookController extends AbstractController
{
    private Messenger $messenger;

    private MessageBusInterface $messageBus;

    public function __construct(MessengerProxy $messengerProxy, MessageBusInterface $messageBus)
    {
        $this->messenger = $messengerProxy->messenger();
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("", methods={"POST"})
     *
     * @return Response
     */
    public function webHookPost(FacebookMessageFactory $factory): Response
    {
        foreach ($this->messenger->webhook()->getCallbackEvents() as $event) {
            /** @var AbstractEvent $event */
            $this->messageBus->dispatch($factory->createByFacebookEvent($event));
        }

        return new Response();
    }

    /**
     * @Route("", methods={"GET"})
     *
     * @return Response
     */
    public function webHookGet(): Response
    {
        $webHook = $this->messenger->webhook();

        if ($webHook->isValidToken()) {
            return new Response($webHook->challenge());
        }

        return new Response('Invalid request', Response::HTTP_BAD_REQUEST);
    }
}
