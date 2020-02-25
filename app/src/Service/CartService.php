<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private FacebookUserService $facebookUserService;

    private EntityManagerInterface $entityManager;

    private CartItemRepository $cartItemRepository;

    /**
     * @param FacebookUserService $facebookUserService
     * @param EntityManagerInterface $entityManager
     * @param CartItemRepository $cartItemRepository
     */
    public function __construct(
        FacebookUserService $facebookUserService,
        EntityManagerInterface $entityManager,
        CartItemRepository $cartItemRepository
    ) {
        $this->facebookUserService = $facebookUserService;
        $this->entityManager = $entityManager;
        $this->cartItemRepository = $cartItemRepository;
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
        $cartItem = $this->cartItemRepository->findOneBy(['cart' => $cart, 'product' => $product]);

        if (!$cartItem) {
            $cartItem = new CartItem($cart, $product);
            $this->entityManager->persist($cartItem);
        } else {
            $cartItem->update($cartItem->quantity() + 1);
        }

        $this->entityManager->flush();
    }
}
