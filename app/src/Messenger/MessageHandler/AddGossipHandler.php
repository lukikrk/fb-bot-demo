<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Entity\Gossip;
use App\Messenger\Message\AddGossip;
use App\Proxy\MessengerProxy;
use App\Service\FacebookUserService;
use Doctrine\ORM\EntityManagerInterface;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddGossipHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    private FacebookUserService $facebookUserService;

    /**
     * @param MessengerProxy $messengerProxy
     * @param EntityManagerInterface $entityManager
     * @param FacebookUserService $facebookUserService
     */
    public function __construct(
        MessengerProxy $messengerProxy,
        EntityManagerInterface $entityManager,
        FacebookUserService $facebookUserService
    ) {
        parent::__construct($messengerProxy);

        $this->entityManager = $entityManager;
        $this->facebookUserService = $facebookUserService;
    }


    public function __invoke(AddGossip $message): void
    {
        $gossip = new Gossip($message->content());

        $this->entityManager->persist($gossip);

        $this->facebookUserService->obtain($message->sender())->update(null);

        $this->entityManager->flush();

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message($message->sender(), 'Ale numer! Tego nie wiedziałam!');
    }
}
