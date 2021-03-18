<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Service\SpotifyAuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SpotifyAuthController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller\Auth
 */
class SpotifyAuthController extends AbstractController
{

    /**
     * Instance of SpotifyService.
     *
     * @var SpotifyAuthService
     */
    private SpotifyAuthService $spotifyAuthService;

    /**
     * SpotifyAuthController constructor.
     *
     * @param SpotifyAuthService $spotifyAuthService
     */
    public function __construct(SpotifyAuthService $spotifyAuthService)
    {
        $this->spotifyAuthService = $spotifyAuthService;
    }

    /**
     * Redirect an user for Spotify access.
     *
     * @Route("/spotify/auth", name="spotify_auth")
     *
     * @return RedirectResponse
     */
    public function authAction(): RedirectResponse
    {
        $spotifyAuthUrl = $this->spotifyAuthService->spotifyUserAuth();

        return $this->redirect($spotifyAuthUrl);
    }

    /**
     * Handle the Spotify access token from an user.
     *
     * @param Request $request
     *
     * @Route("/spotify/auth/callback", name="spotify_auth_callback")
     *
     * @return RedirectResponse
     */
    public function authCallbackAction(Request $request): RedirectResponse
    {
        $this->spotifyAuthService->spotifyUserStoreAccessToken($request->get('code'));

        return $this->redirect($this->generateUrl('app_main'));
    }
}
