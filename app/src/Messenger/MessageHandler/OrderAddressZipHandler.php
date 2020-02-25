<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\OrderAddressZip;
use App\Proxy\MessengerProxy;
use App\Repository\PaymentMethodRepository;
use App\Service\FacebookUserService;
use Doctrine\ORM\EntityManagerInterface;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\QuickReply;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderAddressZipHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private FacebookUserService $facebookUserService;

    private EntityManagerInterface $entityManager;

    private PaymentMethodRepository $paymentMethodRepository;

    /**
     * @param MessengerProxy $messengerProxy
     * @param FacebookUserService $facebookUserService
     * @param EntityManagerInterface $entityManager
     * @param PaymentMethodRepository $paymentMethodRepository
     */
    public function __construct(
        MessengerProxy $messengerProxy,
        FacebookUserService $facebookUserService,
        EntityManagerInterface $entityManager,
        PaymentMethodRepository $paymentMethodRepository
    ) {
        parent::__construct($messengerProxy);

        $this->facebookUserService = $facebookUserService;
        $this->entityManager = $entityManager;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function __invoke(OrderAddressZip $message): void
    {
        $user = $this->facebookUserService->obtain($message->sender());
        $orderAddress = $user->cart()->order()->orderAddress();

        $orderAddress->update($message->content());
        $user->update(null);

        $this->entityManager->flush();

        foreach ($this->paymentMethodRepository->findAll() as $paymentMethod) {
            $paymentMethods[] = QuickReply::create(QuickReply::CONTENT_TYPE_TEXT)
                ->setTitle($paymentMethod->name())
                ->setPayload('PAYMENT-METHOD-'.$paymentMethod->id());
        }

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message(
            $message->sender(),
            (new Message('Super! Teraz wybierz formę płatności 💰'))
                ->setQuickReplies($paymentMethods)
        );
    }
}
