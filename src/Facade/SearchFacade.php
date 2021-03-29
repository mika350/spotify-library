<?php

declare(strict_types=1);

namespace App\Facade;

use App\Service\SpotifyService;

/**
 * Class SearchFacade
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Facade
 */
class SearchFacade
{
    /**
     * Search types for Spotify.
     *
     * @var string
     */
    private const SPOTIFY_SEARCH_TYPES = 'album,artist,playlist,track,show,episode';

    /**
     * Instance of SpotifyService;
     *
     * @var SpotifyService
     */
    private SpotifyService $spotifyService;

    /**
     * SearchFacade constructor.
     *
     * @param SpotifyService $spotifyService
     */
    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /**
     * Search everything on Spotify.
     *
     * @param string $searchQuery
     *
     * @return array|null
     */
    public function search(string $searchQuery): ?object
    {
        return $this->spotifyService->makePublicCall(
            'search',
            $searchQuery,
            self::SPOTIFY_SEARCH_TYPES,
            ['limit' => 10],
        );
    }
}
