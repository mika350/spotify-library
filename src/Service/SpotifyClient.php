<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User\UserEntity;
use App\Entity\User\UserInterface;
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
    private Session $privateSpotifySession;

    /**
     * Instance of Session.
     *
     * @var Session
     */
    private Session $publicSpotifySession;

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
     * @param UserRepository $userRepository
     * @param Session $publicSpotifySession
     * @param Session $privateSpotifySession
     */
    public function __construct(
        SpotifyWebAPI $spotifyWebApi,
        UserRepository $userRepository,
        Session $publicSpotifySession,
        Session $privateSpotifySession
    ) {
        $this->spotifyWebApi = $spotifyWebApi;
        $this->userRepository = $userRepository;
        $this->privateSpotifySession = $privateSpotifySession;
        $this->publicSpotifySession = $publicSpotifySession;
    }

    /**
     * Get the private Spotify-Client.
     *
     * @param UserInterface|null $user
     * @param bool $refreshToken
     *
     * @return SpotifyWebAPI
     */
    public function getPrivateApiClient(UserInterface $user = null, bool $refreshToken = false): SpotifyWebAPI
    {
        if ($user !== null) {
            assert($user instanceof UserEntity);

            if ($refreshToken === true) {
                $this->privateSpotifySession->refreshAccessToken($user->getSpotifyRefreshToken());

                $refreshedAccessToken = $this->privateSpotifySession->getAccessToken();
                $refreshToken = $this->privateSpotifySession->getRefreshToken();

                $user->setSpotifyAccessToken($refreshedAccessToken);
                $user->setSpotifyRefreshToken($refreshToken);

                $this->userRepository->saveUser($user);

                $this->spotifyWebApi->setAccessToken($refreshedAccessToken);
            }

            if ($refreshToken === false) {
                $this->spotifyWebApi->setAccessToken($user->getSpotifyAccessToken());
            }
        }

        return $this->spotifyWebApi;
    }

    /**
     * Get the public Spotify-Client
     *
     * @return SpotifyWebAPI
     */
    public function getPublicApiClient(): SpotifyWebAPI
    {
        $this->publicSpotifySession->requestCredentialsToken();
        $accessToken = $this->publicSpotifySession->getAccessToken();

        $this->spotifyWebApi->setAccessToken($accessToken);

        return $this->spotifyWebApi;
    }
}
