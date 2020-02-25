<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Entity\Order;
use App\Messenger\Enum\QuestionIdEnum;
use App\Messenger\Message\MakeOrder;
use App\Proxy\MessengerProxy;
use App\Service\FacebookUserService;
use Doctrine\ORM\EntityManagerInterface;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MakeOrderHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private FacebookUserService $facebookUserService;

    private EntityManagerInterface $entityManager;

    /**
     * @param MessengerProxy $messengerProxy
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

    public function __invoke(MakeOrder $message): void
    {
        $user = $this->facebookUserService->obtain($message->sender());

        if (!$order = $user->cart()->order()) {
            $order = new Order($user, $user->cart());
        }

        $user->update(QuestionIdEnum::ORDER_ADDRESS_STREET_QUESTION);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);

        $this->messenger->send()->message($message->sender(), 'Czas na odres dostawy 📦');
        $this->messenger->send()->message($message->sender(), 'Podaj ulicę 🏠');
    }
}