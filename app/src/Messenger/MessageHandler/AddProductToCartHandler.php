<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\AddProductToCart;
use App\Proxy\MessengerProxy;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Message\Attachment\Template\ButtonTemplate;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddProductToCartHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private ProductRepository $productRepository;

    private CartService $cartService;

    /**
     * @param MessengerProxy $messengerProxy
     * @param ProductRepository $productRepository
     * @param CartService $cartService
     */
    public function __construct(
        MessengerProxy $messengerProxy,
        ProductRepository $productRepository,
        CartService $cartService
    ) {
        parent::__construct($messengerProxy);

        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
    }

    public function __invoke(AddProductToCart $message): void
    {
        $product = $this->productRepository->find((int) $message->getPayloadParam('productId'));

        $cart = $this->cartService->obtainCartForFacebookUser($message->sender());

        $this->cartService->addProductToCart($cart, $product);

        $this->messenger->send()->action($message->sender(), Send::SENDER_ACTION_TYPING_ON);
        $this->messenger->send()->message($message->sender(), 'Produkt został dodany do koszyka');
        $this->messenger->send()->message($message->sender(), ButtonTemplate::create('Co teraz chcesz zrobić?', [
            Postback::create('Pokaż koszyk', 'SHOW-CART'),
            Postback::create('Złóż zamówienie', 'MAKE-ORDER'),
        ]));
    }
}
