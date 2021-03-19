<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SpotifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
    public function mainAction(SpotifyService $spotifyService): Response
    {
        dump($spotifyService->makeCall()->getMyPlaylists());die;

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'user' => $this->getUser(),
        ]);
    }
}
