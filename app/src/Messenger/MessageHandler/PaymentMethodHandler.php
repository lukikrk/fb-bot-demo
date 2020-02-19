<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Factory\ReceiptTemplateFactory;
use App\Messenger\Message\PaymentMethod;
use App\Proxy\MessengerProxy;
use App\Repository\PaymentMethodRepository;
use App\Service\FacebookUserService;
use Doctrine\ORM\EntityManagerInterface;
use Kerox\Messenger\Api\Send;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PaymentMethodHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private FacebookUserService $facebookUserService;

    private EntityManagerInterface $entityManager;

    private PaymentMethodRepository $paymentMethodRepository;

    private ReceiptTemplateFactory $receiptTemplateFactory;

    /**
     * @param MessengerProxy $messengerProxy
     * @param FacebookUserService $facebookUserService
     * @param EntityManagerInterface $entityManager
     * @param PaymentMethodRepository $paymentMethodRepository
     * @param ReceiptTemplateFactory $receiptTemplateFactory
     */
    public function __construct(
        MessengerProxy $messengerProxy,
        FacebookUserService $facebookUserService,
        EntityManagerInterface $entityManager,
        PaymentMethodRepository $paymentMethodRepository,
        ReceiptTemplateFactory $receiptTemplateFactory
    ) {
        parent::__construct($messengerProxy);

        $this->facebookUserService = $facebookUserService;
        $this->entityManager = $entityManager;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->receiptTemplateFactory = $receiptTemplateFactory;
    }

    public function __invoke(PaymentMethod $message)
    {
        $user = $this->facebookUserService->obtain($message->sender());
        $order = $user->cart()->order();

        $order->update($order->orderAddress(), $this->paymentMethodRepository->find(
            (int) $message->getPayloadParam('paymentMethodId')
        ));

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message($message->sender(), 'Dziękuję za złożenie zamówienia!');
        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message(
            $message->sender(),
            "Jeżeli wybrałeś/aś przelew jako formę płatności, wyślij go na numer".
            "00 0000 0000 0000 0000 0000 0000, a w tytule przelewu wpisz \"Zamówienie nr {$order->id()}\""
        );

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message($message->sender(), $this->receiptTemplateFactory->createForUser($user));

        $user->cart()->update(null);

        $this->entityManager->flush();
    }
}
