<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Service\SpotifyService;
use Doctrine\ORM\EntityManager;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    /**
     * @param SpotifyService $spotifyService
     * @Route("/", name="main")
     *
     * @return Response
     */
    public function mainAction(SpotifyService $spotifyService): Response
    {

        dump($spotifyService->getPlaylists());

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @param EmailVerifier $emailVerifier
     * @param Security $security
     * @return RedirectResponse
     * @Route("/resend-email", name="resend-email")
     *
     */
    public function resendConfirmMailAction(EmailVerifier $emailVerifier, Security $security): RedirectResponse
    {
        $user = $security->getUser();

        $emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('test@exmaple.com', 'Test Bot'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
            );

        return $this->redirect('main');
    }
}
