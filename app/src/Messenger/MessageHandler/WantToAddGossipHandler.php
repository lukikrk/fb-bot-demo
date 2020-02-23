<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Enum\QuestionIdEnum;
use App\Messenger\Message\WantToAddGossip;
use App\Proxy\MessengerProxy;
use App\Service\FacebookUserService;
use Doctrine\ORM\EntityManagerInterface;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class WantToAddGossipHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private FacebookUserService $facebookUserService;

    private EntityManagerInterface $entityManager;

    /**
     * @param FacebookUserService $facebookUserService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        MessengerProxy $messengerProxy,
        FacebookUserService $facebookUserService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($messengerProxy);

        $this->facebookUserService = $facebookUserService;
        $this->entityManager = $entityManager;
    }

    public function __invoke(WantToAddGossip $message): void
    {
        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message($message->sender(), 'No więc co tam ciekawego wiesz?');

        $facebookUser = $this->facebookUserService->obtain($message->sender());
        $facebookUser->update(QuestionIdEnum::ADD_GOSSIP_QUESTION);

        $this->entityManager->flush();
    }
}
