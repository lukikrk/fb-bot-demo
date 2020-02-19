<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\FacebookUser;
use App\Entity\OrderAddress;
use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Model\Message\Attachment\Template\ReceiptTemplate;

class ReceiptTemplateFactory
{
    public function createForUser(FacebookUser $user): ReceiptTemplate
    {
        $order = $user->cart()->order();

        return ReceiptTemplate::create(
            $user->firstName().' '. $user->lastName(),
            (string) $order->id(),
            'PLN',
            $order->paymentMethod()->name(),
            $this->createReceiptElements($user->cart()->items()),
            Summary::create($order->totalPrice())
        )->setAddress($this->createReceiptAddress($order->orderAddress()));
    }

    private function createReceiptElements(array $cartItems): array
    {
        foreach ($cartItems as $item) {
            $product = $item->product();

            $receiptElements[] = ReceiptElement::create($product->name(), $product->price())
                ->setImageUrl($product->imageUrl())
                ->setQuantity($item->quantity());
        }

        return $receiptElements;
    }

    private function createReceiptAddress(OrderAddress $orderAddress): Address
    {
        return Address::create(
            $orderAddress->street(),
            'Kraków',
            $orderAddress->zip(),
            'Małopolska',
            'Polska'
        );
    }
}
