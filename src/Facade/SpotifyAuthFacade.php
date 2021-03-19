<?php

declare(strict_types=1);

namespace App\Facade;

use App\Entity\User;
use App\Service\SpotifyAuthService;

/**
 * Class SpotifyAuthFacade
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Facade
 */
class SpotifyAuthFacade
{
    /**
     * @var SpotifyAuthService
     */
    private SpotifyAuthService $spotifyAuthService;

    /**
     * SpotifyAuthFacade constructor.
     *
     * @param SpotifyAuthService $spotifyAuthService
     */
    public function __construct(SpotifyAuthService $spotifyAuthService)
    {
        $this->spotifyAuthService = $spotifyAuthService;
    }

    /**
     * Generate Spotify-App authorization URL.
     *
     * @return string
     */
    public function getAuthUrl(): string
    {
        return $this->spotifyAuthService->generateSpotifyAuthUrl();
    }

    /**
     * Store the users access and refresh key.
     *
     * @param string $spotifyCode
     *
     * @return void
     */
    public function requestAndStoreAccessKeys(string $spotifyCode): void
    {
        $this->spotifyAuthService->storeUserSpotifyAccessCodes($spotifyCode);
    }
}