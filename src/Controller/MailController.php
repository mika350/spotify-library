<?php

declare(strict_types=1);

namespace App\Controller;

use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * Class MailController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller
 */
class MailController extends AbstractController
{
    /**
     * Resend the confirm mail to an user.
     *
     * @Route("/resend-email", name="resend-email")
     *
     * @param EmailVerifier $emailVerifier
     * @param Security $security
     *
     * @return RedirectResponse
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

    /**
     * Verify an users email address.
     *
     * @Route("/verify/email", name="app_verify_email")
     *
     * @param EmailVerifier $emailVerifier
     * @param Request $request
     *
     * @return Response
     */
    public function verifyUserEmail(EmailVerifier $emailVerifier, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $emailVerifier->handleEmailConfirmation($request, $this->getUser());

            $redirectReturn = $this->redirectToRoute('main');
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            $redirectReturn = $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        return $redirectReturn;
    }
}
