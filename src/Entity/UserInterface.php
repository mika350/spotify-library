<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface as DefaultUserInterface;

/**
 * Interface UserInterface
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Entity
 */
interface UserInterface extends DefaultUserInterface
{
    /**
     * Get the users email address.
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Get the spotify access token.
     *
     * @return string|null
     */
    public function getSpotifyAccessToken(): ?string;

    /**
     * Get the spotify refresh token.
     *
     * @return string|null
     */
    public function getSpotifyRefreshToken(): ?string;

    /**
     * Set the users email address.
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self;

    /**
     * Set the spotify access token.
     *
     * @param string $accessToken
     *
     * @return self
     */
    public function setSpotifyAccessToken(string $accessToken): self;

    /**
     * Set the spotify refresh token.
     *
     * @param string $accessToken
     *
     * @return self
     */
    public function setSpotifyRefreshToken(string $accessToken): self;
}
