<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Component\Security\Core\Security;

class SpotifyService
{
    private Security $security;

    private SpotifyWebAPI $spotifyWebAPI;

    public function __construct(SpotifyWebAPI $spotifyWebAPI, Security $security)
    {
        $this->spotifyWebAPI = $spotifyWebAPI;
        $this->security = $security;
    }

    public function getPlaylists()
    {
        $currentUser = $this->security->getUser();

        assert($currentUser instanceof User);

        $this->spotifyWebAPI->setAccessToken($currentUser->getSpotifyAccessToken());

        return $this->spotifyWebAPI->getMyPlaylists();
    }
}