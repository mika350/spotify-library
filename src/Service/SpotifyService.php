<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User\UserInterface;
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
     * Instance of Security.
     *
     * @var Security
     */
    private Security $security;

    /**
     * Instance of SpotifyClient.
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
    public function makeCall(): SpotifyWebAPI
    {
        return $this->spotifyClient->getApiClient($this->currentUser);
    }

//    /**
//     * Get the current playback info.
//     *
//     * @return array|object
//     */
//    public function getCurrentPlayback(): object
//    {
//        return $this->client()->getMyCurrentPlaybackInfo();
//    }
//
//    /**
//     * Get the users playlists.
//     *
//     * @return object
//     */
//    protected function getPlaylists(): object
//    {
//        return $this->client()->getMyPlaylists();
//    }
//
//    public function makeCall(): self
//    {
//        try {
//            return $this;
//        } catch (\Exception $exception) {
//
//        }
//    }
}
