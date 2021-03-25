<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SpotifyService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller
 */
class MainController extends BaseController
{
    /**
     * Main action.
     *
     * @Route("/", name="app_main")
     *
     * @param SpotifyService $spotifyService
     *
     * @return Response
     */
    public function mainAction(SpotifyService $spotifyService): Response
    {
        dump($this->getUser());

//        dump($spotifyService->makePublicCall('getTrack', '7EjyzZcbLxW7PaaLua9Ksb'));
//        dump($spotifyService->makePrivateCall('getMyPlaylists'));

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'user' => $this->getUser(),
        ]);
    }
}
