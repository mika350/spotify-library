<?php

declare(strict_types=1);

namespace App\Facade\Auth;

use App\Entity\User;
use App\Entity\User\UserEntity;
use App\Security\EmailVerifier;
use App\Service\EmailService;
use App\Service\UserService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * Instance of UserService.
     *
     * @var UserService
     */
    private UserService $userService;

    /**
     * RegistrationFacade constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EmailVerifier $emailVerifier
     * @param EmailService $emailService
     * @param UserService $userService
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EmailVerifier $emailVerifier,
        EmailService $emailService,
        UserService $userService
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->emailVerifier = $emailVerifier;
        $this->emailService = $emailService;
        $this->userService = $userService;
    }

    /**
     * Handle the register form data.
     *
     * @param UserEntity $user
     * @param FormInterface $form
     *
     * @return void
     */
    public function handleRegisterForm(UserEntity $user, FormInterface $form): void
    {
        assert($user instanceof UserInterface);

        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData(),
            ),
        );

        $this->userService->saveUser($user);

        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            $this->emailService->generateConfirmMail($user),
        );
    }
}
