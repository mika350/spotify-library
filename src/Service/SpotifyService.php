<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\UserInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class SpotifyService
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Service
 */
class SpotifyService
{
    /**
     * Security component
     *
     * @var Security
     */
    private Security $security;

    /**
     * The Spotify client.
     *
     * @var SpotifyClient
     */
    private SpotifyClient $spotifyClient;

    /**
     * SpotifyService constructor.
     *
     * @param Security $security
     * @param SpotifyClient $spotifyClient
     */
    public function __construct(Security $security, SpotifyClient $spotifyClient)
    {
        $this->security = $security;
        $this->spotifyClient = $spotifyClient;
    }

    /**
     * Get the users playlists
     *
     * @return array|object
     */
    public function getPlaylists()
    {
        $currentUser = $this->security->getUser();

        assert($currentUser instanceof UserInterface);

        return $this->spotifyClient->getApiClient($currentUser)->getMyPlaylists();
    }
}
