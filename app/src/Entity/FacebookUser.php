<?php

declare(strict_types=1);

namespace App\Entity;

class FacebookUser extends AbstractEntity
{
    private string $facebookId;

    private string $firstName;

    private string $lastName;

    private string $profilePic;

    private string $locale;

    private ?string $questionId;

    private ?Cart $cart = null;

    /**
     * @param string $facebookId
     * @param string $firstName
     * @param string $lastName
     * @param string $profilePic
     * @param string $locale
     */
    public function __construct(
        string $facebookId,
        string $firstName,
        string $lastName,
        string $profilePic,
        string $locale
    ) {
        $this->facebookId = $facebookId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->profilePic = $profilePic;
        $this->locale = $locale;
    }

    public function update(?string $questionId): void
    {
        $this->questionId = $questionId;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function questionId(): ?string
    {
        return $this->questionId;
    }

    public function cart(): ?Cart
    {
        return $this->cart;
    }
}
