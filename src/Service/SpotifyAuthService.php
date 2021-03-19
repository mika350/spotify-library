<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\User\UserEntity;
use Doctrine\ORM\EntityManager;
use SpotifyWebAPI\Session;
use Symfony\Component\Security\Core\Security;

/**
 * Class SpotifyAuthService
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Service
 */
class SpotifyAuthService
{
    /**
     * Instance of Session.
     *
     * @var Session
     */
    private Session $spotifySession;

    /**
     * Instance of Security.
     *
     * @var Security
     */
    private Security $security;

    /**
     * Instance of EntityManager.
     *
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * SpotifyAuthService constructor.
     *
     * @param Session $spotifySession
     * @param Security $security
     * @param EntityManager $entityManager
     */
    public function __construct(Session $spotifySession, Security $security, EntityManager $entityManager)
    {
        $this->spotifySession = $spotifySession;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * Generate Spotify-App authorization URL.
     *
     * @return string
     */
    public function generateSpotifyAuthUrl(): string
    {
        $state = $this->spotifySession->generateState();
        $options = [
            'scope' => [
                'playlist-read-private',
                'user-read-recently-played',
                'user-read-playback-position',
                'app-remote-control',
                'streaming',
                'user-read-playback-state',
            ],
            'state' => $state,
        ];

        return $this->spotifySession->getAuthorizeUrl($options);
    }

    /**
     * Store the users access and refresh key.
     *
     * @param string $spotifyCode
     *
     * @return void
     */
    public function storeUserSpotifyAccessCodes(string $spotifyCode): void
    {
        $currentUser = $this->security->getUser();

        assert($currentUser instanceof UserEntity);

        $this->spotifySession->requestAccessToken($spotifyCode);

        $accessToken = $this->spotifySession->getAccessToken();
        $refreshToken = $this->spotifySession->getRefreshToken();

        $currentUser->setSpotifyAccessToken($accessToken);
        $currentUser->setSpotifyRefreshToken($refreshToken);

        $this->entityManager->getRepository(User::class)->saveUser($currentUser);
    }
}
