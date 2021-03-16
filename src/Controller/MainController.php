<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\SpotifyService;
use Doctrine\ORM\EntityManager;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     *
     * @param SpotifyService $spotifyService
     * @return Response
     */
    public function main(SpotifyService $spotifyService): Response
    {

        dump($spotifyService->getPlaylists());

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
