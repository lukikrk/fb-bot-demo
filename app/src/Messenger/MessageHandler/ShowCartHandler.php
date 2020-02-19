<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\ShowCart;
use App\Proxy\MessengerProxy;
use App\Service\FacebookUserService;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ShowCartHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private FacebookUserService $facebookUserService;

    /**
     * @param MessengerProxy $messengerProxy
     * @param FacebookUserService $facebookUserService
     */
    public function __construct(MessengerProxy $messengerProxy, FacebookUserService $facebookUserService)
    {
        parent::__construct($messengerProxy);

        $this->facebookUserService = $facebookUserService;
    }

    public function __invoke(ShowCart $message): void
    {
        $user = $this->facebookUserService->obtain($message->sender());

        if (!($cart = $user->cart()) || !$cart->items()->count()) {
            $this->messenger->send()->message($message->sender(), 'Twój koszyk jest pusty');

            return;
        }

        foreach ($cart->items() as $item) {
            $product = $item->product();
            $elements[] = GenericElement::create($product->name())
                ->setSubtitle(
                    "Ilość: ".$item->quantity()."\nRazem: ".number_format($item->totalPrice(), 2)."zł"
                )
                ->setImageUrl($product->imageUrl());
        }

        $this->messenger->send()->message($message->sender(), new GenericTemplate($elements));
    }
}
