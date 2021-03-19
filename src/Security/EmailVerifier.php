<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * Class EmailVerifier
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Security
 */
class EmailVerifier
{
    /**
     * Instance of VerifyEmailHelperInterface.
     *
     * @var VerifyEmailHelperInterface
     */
    private VerifyEmailHelperInterface $verifyEmailHelper;

    /**
     * Instance of MailerInterface.
     *
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * Instance of EntityManagerInterface.
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * EmailVerifier constructor.
     *
     * @param VerifyEmailHelperInterface $helper
     * @param MailerInterface $mailer
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        VerifyEmailHelperInterface $helper,
        MailerInterface $mailer,
        EntityManagerInterface $manager
    ) {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
        $this->entityManager = $manager;
    }

    /**
     * Handle the confirm call.
     *
     * @throws VerifyEmailExceptionInterface Thrown if email address could not be validated.
     *
     * @param Request $request
     * @param UserInterface $user
     *
     * @return void
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation(
            $request->getUri(),
            (string) $user->getId(),
            $user->getEmail(),
        );

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Send the confirm mail.
     *
     * @throws TransportExceptionInterface Thrown if the mail could not be sent.
     *
     * @param string $verifyEmailRouteName
     * @param UserInterface $user
     * @param TemplatedEmail $email
     *
     * @return void
     */
    public function sendEmailConfirmation(
        string $verifyEmailRouteName,
        UserInterface $user,
        TemplatedEmail $email
    ): void {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            (string) $user->getId(),
            $user->getEmail(),
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }
}
