<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User\UserInterface;
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
     * @var UserInterface|null
     */
    private ?UserInterface $currentUser = null;

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

        if ($this->security->getUser() !== null) {
            $this->currentUser = $this->security->getUser();
        }
    }

    /**
     * Make an API-call in private user context.
     *
     * @param string $method
     * @param array $args
     *
     * @return object|null
     */
    public function makePrivateCall(string $method, ...$args): ?object
    {
        // TODO: Refactor this method.

        $result = null;

        try {
            $spotifyClient = $this->spotifyClient->getPrivateApiClient($this->currentUser);

            $result = $spotifyClient->{$method}(...$args);
        } catch (SpotifyWebAPIException $exception) {
            if ($exception->hasExpiredToken()) {
                $spotifyClient = $this->spotifyClient->getPrivateApiClient($this->currentUser, true);

                $result = $spotifyClient->{$method}(...$args);

                dump('REFRESHED TOKENS');
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

    /**
     * Make an API-call in public context.
     *
     * @param string $method
     * @param array $args
     *
     * @return object|null
     */
    public function makePublicCall(string $method, ...$args): ?object
    {
        // TODO: Refactor this method.

        $result = null;

        try {
            $spotifyClient = $this->spotifyClient->getPublicApiClient();

            $result = $spotifyClient->{$method}(...$args);
        } catch (SpotifyWebAPIException $exception) {
            dump('ERROR ON PUBLIC API CALL');
            // TODO: Add error handling.
        }

        return $result;
    }
}
