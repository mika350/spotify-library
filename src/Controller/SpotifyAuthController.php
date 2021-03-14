<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpotifyAuthController extends AbstractController
{
    /**
     * @Route("/spotify/auth", name="spotify_auth")
     */
    public function authAction()
    {
        $session = new Session(
            '72773783c84c42619692ad0dadb4c63c',
            'a8718b3730924d5f80fcc4f72bdc8071',
            'http://127.0.0.1:8085/spotify/auth/callback'
        );

        $state = $session->generateState();
        $options = [
            'scope' => [
                'playlist-read-private',
                'user-read-private',
                'streaming',
                'app-remote-control',
                'user-modify-playback-state'
            ],
            'state' => $state,
        ];

        return $this->redirect($session->getAuthorizeUrl($options));
    }

    /**
     * @Route("/spotify/auth/callback", name="spotify_auth_callback")
     *
     * @param Request $request
     */
    public function authCallbackAction(Request $request)
    {
        $session = new Session(
            '72773783c84c42619692ad0dadb4c63c',
            'a8718b3730924d5f80fcc4f72bdc8071',
            'http://127.0.0.1:8085/spotify/auth/callback'
        );




        $api = new SpotifyWebAPI();

        $session->requestAccessToken($_GET['code']);
        $api->setAccessToken($session->getAccessToken());

        /** @var EntityManagerInterface $em */
        $em = $this->getDoctrine()->getManager();

        $user = $em->find(User::class, 1);

        $user->setSpotifyAccessToken($session->getAccessToken());


        $em->persist($user);
        $em->flush();


        return $this->redirect($this->generateUrl('main'));
    }
}
