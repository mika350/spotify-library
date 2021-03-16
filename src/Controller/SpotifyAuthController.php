<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SpotifyAuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpotifyAuthController extends AbstractController
{
    /**
     * @param SpotifyAuthService $spotifyService
     * @Route("/spotify/auth", name="spotify_auth")
     *
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
        $spotifyService->spotifyUserStoreAccessToken($request->get('code'));

        return $this->redirect($this->generateUrl('main'));
    }
}
