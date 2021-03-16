<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface as DefaultUserInterface;

/**
 * Interface UserInterface
 *
 * @author Mika Bertels <info@bestit.de>
 * @package App\Entity
 */
interface UserInterface extends DefaultUserInterface
{
    /**
     * Get the spotify access token.
     *
     * @return string|null
     */
    public function getSpotifyAccessToken(): ?string;

    /**
     * Set the spotify access token.
     *
     * @param string $accessToken
     *
     * @return self
     */
    public function setSpotifyAccessToken(string $accessToken): self;

    public function getEmail(): ?string;

    public function setEmail(string $email): self;
}