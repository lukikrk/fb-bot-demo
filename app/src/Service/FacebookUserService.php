<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FacebookUser;
use App\Proxy\MessengerProxy;
use App\Repository\FacebookUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Kerox\Messenger\Messenger;

class FacebookUserService
{
    private FacebookUserRepository $facebookUserRepository;

    private Messenger $messenger;

    private EntityManagerInterface $entityManager;

    /**
     * @param FacebookUserRepository $facebookUserRepository
     */
    public function __construct(
        FacebookUserRepository $facebookUserRepository,
        MessengerProxy $messengerProxy,
        EntityManagerInterface $entityManager
    ) {
        $this->facebookUserRepository = $facebookUserRepository;
        $this->messenger = $messengerProxy->messenger();
        $this->entityManager = $entityManager;
    }

    public function obtain(string $facebookId): FacebookUser
    {
        $facebookUser = $this->facebookUserRepository->findOneBy(['facebookId' => $facebookId]);

        if ($facebookUser) {
            return $facebookUser;
        }

        $profile = $this->messenger->user()->profile($facebookId);

        $facebookUser = new FacebookUser(
            $facebookId,
            $profile->getFirstName(),
            $profile->getLastName(),
            $profile->getProfilePic(),
            $profile->getLocale()
        );

        $this->entityManager->persist($facebookUser);
        $this->entityManager->flush();

        return $facebookUser;
    }
}
