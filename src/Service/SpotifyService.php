<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\UserInterface;
use Symfony\Component\Security\Core\Security;

class SpotifyService
{
    private Security $security;
    /**
     * @var SpotifyClient
     */
    private SpotifyClient $spotifyClient;


    public function __construct(Security $security, SpotifyClient $spotifyClient)
    {
        $this->security = $security;
        $this->spotifyClient = $spotifyClient;
    }

    public function getPlaylists()
    {
        $currentUser = $this->security->getUser();

        assert($currentUser instanceof UserInterface);

        return $this->spotifyClient->getApiClient($currentUser)->getMyPlaylists();
    }
}
