<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserInterface;
use SpotifyWebAPI\SpotifyWebAPI;
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
     * Instance of currently logged in User.
     *
     * @var UserInterface
     */
    private UserInterface $currentUser;

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

        $this->currentUser = $this->security->getUser();
    }

    /**
     * Get the SpotifyApiClient.
     *
     * @return SpotifyWebAPI
     */
    private function client(): SpotifyWebAPI
    {
        return $this->spotifyClient->getApiClient($this->currentUser);
    }

    /**
     * Get the users playlists.
     *
     * @return object
     */
    public function getPlaylists(): object
    {
        return $this->client()->getMyPlaylists();
    }

    /**
     * Get the current playback info.
     *
     * @return array|object
     */
    public function getCurrentPlayback(): object
    {
        return $this->client()->getMyCurrentPlaybackInfo();
    }
}
