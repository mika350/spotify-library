<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Facade\SpotifyAuthFacade;
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
     * Instance of SpotifyAuthFacade.
     *
     * @var SpotifyAuthFacade
     */
    private SpotifyAuthFacade $spotifyAuthFacade;

    /**
     * SpotifyAuthController constructor.
     *
     * @param SpotifyAuthFacade $spotifyAuthFacade
     */
    public function __construct(SpotifyAuthFacade $spotifyAuthFacade)
    {
        $this->spotifyAuthFacade = $spotifyAuthFacade;
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
        $spotifyAuthUrl = $this->spotifyAuthFacade->getAuthUrl();

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
        $this->spotifyAuthFacade->requestAndStoreAccessKeys($request->get('code'));

        return $this->redirect($this->generateUrl('app_main'));
    }
}
