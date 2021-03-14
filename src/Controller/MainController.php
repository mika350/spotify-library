<?php

namespace App\Controller;

use App\Service\SpotifyService;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     *
     * @return Response
     */
    public function main(): Response
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $entityManager->find(User::class, 1);

        dump($user);


        $api = new SpotifyWebAPI();

        $api->setAccessToken($user->getSpotifyAccessToken());

        dump(
            $api->me()
        );

        dump(
            $api->getTrack('7EjyzZcbLxW7PaaLua9Ksb')
        );






        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
