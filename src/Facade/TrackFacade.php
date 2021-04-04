<?php

declare(strict_types=1);

namespace App\Facade;

use App\Service\SpotifyService;

/**
 * Class TrackFacade
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Facade
 */
class TrackFacade
{
    /**
     * Instance of SpotifyService.
     *
     * @var SpotifyService
     */
    private SpotifyService $spotifyService;

    /**
     * TrackFacade constructor.
     *
     * @param SpotifyService $spotifyService
     */
    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /**
     * Get the details from a track by it's ID and fetch the artist if there is only one artist.
     *
     * @param string $trackId
     *
     * @return object|null
     */
    public function getTrackDetails(string $trackId): ?object
    {
        return $this->spotifyService->makePublicCall('getTrack', $trackId);
    }
}
