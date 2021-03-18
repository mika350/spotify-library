<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Entity\User;
use App\Facade\Auth\RegistrationFacade;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller\Auth
 */
class RegistrationController extends AbstractController
{
    /**
     * Instance of RegistrationFacade.
     *
     * @var RegistrationFacade
     */
    private RegistrationFacade $registrationFacade;

    /**
     * RegistrationController constructor.
     *
     * @param RegistrationFacade $registrationFacade
     */
    public function __construct(RegistrationFacade $registrationFacade)
    {
        $this->registrationFacade = $registrationFacade;
    }

    /**
     * Register a new user.
     *
     * @param Request $request
     *
     * @Route("/register", name="app_register")
     *
     * @return Response
     */
    public function register(Request $request): Response
    {
        $user = new User();
        $return = new Response();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $return = $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->registrationFacade->handleRegisterForm($user, $form);

            $return = $this->redirectToRoute('app_main');
        }

        return $return;
    }
}
