<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use SpotifyWebAPI\Session;
use Symfony\Component\Security\Core\Security;

class SpotifyAuthService
{
    private Session $spotifySession;
    private Security $security;
    private EntityManager $entityManager;

    public function __construct(Session $spotifySession, Security $security, EntityManager $entityManager)
    {
        $this->spotifySession = $spotifySession;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function spotifyUserAuth(): string
    {
        $state = $this->spotifySession->generateState();
        $options = [
            'scope' => [
                'playlist-read-private',
            ],
            'state' => $state,
        ];

        return $this->spotifySession->getAuthorizeUrl($options);
    }

    public function spotifyUserStoreAccessToken(string $spotifyCode)
    {
        $currentUser = $this->security->getUser();

        assert($currentUser instanceof User);

        $this->spotifySession->requestAccessToken($spotifyCode);

        $accessToken = $this->spotifySession->getAccessToken();
        $refreshToken = $this->spotifySession->getRefreshToken();

        $currentUser->setSpotifyAccessToken($accessToken);
        $currentUser->setSpotifyRefreshToken($refreshToken);

        $this->entityManager->getRepository(User::class)->updateUser($currentUser);
    }
}
