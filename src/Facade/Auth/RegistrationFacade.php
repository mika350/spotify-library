<?php

declare(strict_types=1);

namespace App\Facade\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Service\EmailService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationFacade
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Facade\Auth
 */
class RegistrationFacade
{
    /**
     * Instance of UserPasswordEncoderInterface.
     *
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * Instance of EmailVerifier.
     *
     * @var EmailVerifier $emailVerifier
     */
    private EmailVerifier $emailVerifier;

    /**
     * Instance of EmailService.
     *
     * @var EmailService
     */
    private EmailService $emailService;

    /**
     * Instance of UserRepository.
     *
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * RegistrationFacade constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EmailVerifier $emailVerifier
     * @param EmailService $emailService
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EmailVerifier $emailVerifier,
        EmailService $emailService,
        UserRepository $userRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->emailVerifier = $emailVerifier;
        $this->emailService = $emailService;
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the register form data.
     *
     * @param User $user
     * @param FormInterface $form
     *
     * @return void
     */
    public function handleRegisterForm(User $user, FormInterface $form): void
    {
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData(),
            ),
        );

        $this->userRepository->saveUser($user);

        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            $this->emailService->generateConfirmMail($user),
        );
    }
}
