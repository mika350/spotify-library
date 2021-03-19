<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller\Auth
 */
class LoginController extends BaseController
{
    /**
     * Instance of AuthenticationUtils
     *
     * @var AuthenticationUtils
     */
    private AuthenticationUtils $authenticationUtils;

    /**
     * LoginController constructor.
     *
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * Login an user.
     *
     * @Route("/login", name="app_login")
     *
     * @return Response
     */
    public function login(): Response
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            ['last_username' => $lastUsername, 'error' => $error],
        );
    }

    /**
     * Logout an user.
     *
     * @Route("/logout", name="app_logout")
     *
     * @return void
     */
    public function logout(): void
    {
    }
}
