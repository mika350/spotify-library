<?php

declare(strict_types=1);

namespace App\Facade;

use App\Service\SpotifyService;

/**
 * Class ArtistFacade
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Facade
 */
class ArtistFacade
{
    /**
     * Instance of SpotifyService.
     *
     * @var SpotifyService
     */
    private SpotifyService $spotifyService;

    /**
     * ArtistFacade constructor.
     *
     * @param SpotifyService $spotifyService
     */
    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /**
     * Get artist details by ID.
     *
     * @param string $artistId
     *
     * @return object|null
     */
    public function getArtistDetails(string $artistId): ?object
    {
        return $this->spotifyService->makePublicCall('getArtist', $artistId);
    }
}
