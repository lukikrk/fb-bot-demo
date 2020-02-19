<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private FacebookUserService $facebookUserService;

    private EntityManagerInterface $entityManager;

    /**
     * @param FacebookUserService $facebookUserService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(FacebookUserService $facebookUserService, EntityManagerInterface $entityManager)
    {
        $this->facebookUserService = $facebookUserService;
        $this->entityManager = $entityManager;
    }

    public function obtainCartForFacebookUser(string $facebookId): Cart
    {
        $user = $this->facebookUserService->obtain($facebookId);

        if ($cart = $user->cart()) {
            return $cart;
        }

        $this->entityManager->persist($cart = new Cart($user));
        $this->entityManager->flush();

        return $cart;
    }

    public function addProductToCart(Cart $cart, Product $product): void
    {
        $cartItem = new CartItem($cart, $product);

        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();
    }
}
