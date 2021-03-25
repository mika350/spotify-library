<?php

declare(strict_types=1);

namespace App\Provider;

use App\Service\SpotifyService;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserProvider
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Provider
 */
class UserProvider
{
    /**
     * Instance of Security.
     *
     * @var Security
     */
    private Security $security;

    /**
     * Instance of SpotifyService.
     *
     * @var SpotifyService
     */
    private SpotifyService $spotifyService;

    /**
     * UserProvider constructor.
     *
     * @param Security $security
     * @param SpotifyService $spotifyService
     */
    public function __construct(Security $security, SpotifyService $spotifyService)
    {
        $this->security = $security;
        $this->spotifyService = $spotifyService;
    }

    /**
     * Get the users current playback.
     *
     * @return object|null
     */
    public function getCurrentPlayback(): ?object
    {
        return $this->spotifyService->makePrivateCall('getMyCurrentPlaybackInfo');
    }

    /**
     * Check if an user is logged in.
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->security->getUser() ? true : false;
    }

    public function getUsersPlaylists(): ?object
    {
        return $this->spotifyService->makePrivateCall('getMyPlaylists');
    }
}
