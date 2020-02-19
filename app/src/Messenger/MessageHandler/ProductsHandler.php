<?php

declare(strict_types=1);

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\Products;
use App\Proxy\MessengerProxy;
use App\Repository\ProductRepository;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ProductsHandler extends AbstractFacebookEventHandler implements MessageHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(MessengerProxy $messengerProxy, ProductRepository $productRepository)
    {
        parent::__construct($messengerProxy);

        $this->productRepository = $productRepository;
    }

    public function __invoke(Products $message)
    {
        foreach ($this->productRepository->findAll() as $product) {
            $elements[] = GenericElement::create($product->name())
                ->setSubtitle(number_format($product->price(), 2).'zł')
                ->setImageUrl($product->imageUrl())
                ->setButtons([
                    Postback::create('Kup', 'CART-ADD-'.$product->id())
                ]);
        }

        $this->messenger->send()->message($message->sender(), GenericTemplate::create($elements));
    }
}
