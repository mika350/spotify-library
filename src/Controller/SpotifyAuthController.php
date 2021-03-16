<?php

namespace App\Controller;

use App\Service\SpotifyAuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpotifyAuthController extends AbstractController
{
    /**
     * @Route("/spotify/auth", name="spotify_auth")
     *
     * @param SpotifyAuthService $spotifyService
     * @return RedirectResponse
     */
    public function authAction(SpotifyAuthService $spotifyService): RedirectResponse
    {
        $spotifyAuthUrl = $spotifyService->spotifyUserAuth();

        return $this->redirect($spotifyAuthUrl);
    }

    /**
     * @Route("/spotify/auth/callback", name="spotify_auth_callback")
     *
     * @param SpotifyAuthService $spotifyService
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function authCallbackAction(SpotifyAuthService $spotifyService, Request $request): RedirectResponse
    {
        dump($request->get('code'));

        $spotifyService->spotifyUserStore($request->get('code'));

        return $this->redirect($this->generateUrl('main'));
    }
}
