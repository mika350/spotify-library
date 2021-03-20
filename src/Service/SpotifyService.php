<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User\UserInterface;
use Closure;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPIException;
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
     * @param string $method
     * @param array $args
     *
     * @return object|null
     */
    public function makeCall(string $method, array ...$args): ?object
    {
        // TODO: Refactor this method.

        $result = null;

        try {
            $spotifyClient = $this->spotifyClient->getApiClient($this->currentUser);

            $result = $spotifyClient->{$method}(...$args);
        } catch (SpotifyWebAPIException $exception) {
            if ($exception->hasExpiredToken()) {
                $spotifyClient = $this->spotifyClient->getApiClient($this->currentUser, true);

                $result = $spotifyClient->{$method}(...$args);

                dump('REFACTORED TOKENS');
            } elseif ($exception->isRateLimited()) {
                $result = null;

                dump('RATE LIMIT REACHED');
                // TODO: Add rate limit retry.
            } else {
                $result = null;

                dump('OTHER SPOTIFY WEB API ERROR');
                // TODO: Add other error handling.
            }
        }

        return $result;
    }
}
