<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserInterface;
use App\Repository\UserRepository;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

/**
 * Class SpotifyClient
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Service
 */
class SpotifyClient
{
    /**
     * Instance of SpotifyWebAPI.
     *
     * @var SpotifyWebAPI
     */
    private SpotifyWebAPI $spotifyWebApi;

    /**
     * Instance of Session.
     *
     * @var Session
     */
    private Session $spotifySession;

    /**
     * Instance of UserRepository.
     *
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * SpotifyClient constructor.
     *
     * @param SpotifyWebAPI $spotifyWebApi
     * @param Session $spotifySession
     * @param UserRepository $userRepository
     */
    public function __construct(
        SpotifyWebAPI $spotifyWebApi,
        Session $spotifySession,
        UserRepository $userRepository
    ) {
        $this->spotifyWebApi = $spotifyWebApi;
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

            $this->spotifyWebApi->setAccessToken($refreshedAccessToken);
        }

        return $this->spotifyWebApi;
    }
}
