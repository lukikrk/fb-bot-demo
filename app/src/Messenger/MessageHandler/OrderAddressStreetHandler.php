<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Entity\OrderAddress;
use App\Messenger\Message\OrderAddressStreet;
use App\Proxy\MessengerProxy;
use App\Service\FacebookUserService;
use Doctrine\ORM\EntityManagerInterface;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderAddressStreetHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
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

    public function __invoke(OrderAddressStreet $message): void
    {
        $user = $this->facebookUserService->obtain($message->sender());
        $order = $user->cart()->order();

        $order->update(new OrderAddress($message->content()), null);
        $user->update('ORDER_ADDRESS_ZIP_QUESTION');

        $this->entityManager->flush();

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message($message->sender(), 'Doskonale! Teraz podaj kod pocztowy');
    }
}
