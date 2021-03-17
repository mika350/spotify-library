<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserInterface;
use App\Repository\UserRepository;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyClient
{
    private SpotifyWebAPI $spotifyWebAPI;

    private Session $spotifySession;

    private UserRepository $userRepository;

    /**
     * SpotifyClient constructor.
     *
     * @param SpotifyWebAPI $spotifyWebAPI
     * @param Session $spotifySession
     * @param UserRepository $userRepository
     */
    public function __construct(
        SpotifyWebAPI $spotifyWebAPI,
        Session $spotifySession,
        UserRepository $userRepository
    ) {
        $this->spotifyWebAPI = $spotifyWebAPI;
        $this->spotifySession = $spotifySession;
        $this->userRepository = $userRepository;
    }

    /**
     * Get the Spotify-Client.
     *
     * @param UserInterface|null $user
     *
     * @return SpotifyWebAPI
     */
    public function getApiClient(UserInterface $user = null): SpotifyWebAPI
    {
        if ($user !== null) {
            assert($user instanceof User);

            $this->spotifySession->refreshAccessToken($user->getSpotifyRefreshToken());

            $refreshedAccessToken = $this->spotifySession->getAccessToken();
            $refreshToken = $this->spotifySession->getRefreshToken();

            $user->setSpotifyAccessToken($refreshedAccessToken);
            $user->setSpotifyRefreshToken($refreshToken);

            $this->userRepository->saveUser($user);

            $this->spotifyWebAPI->setAccessToken($refreshedAccessToken);
        }

        return $this->spotifyWebAPI;
    }
}
