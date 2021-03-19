<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\User\UserEntity;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

/**
 * Class EmailService
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Service
 */
class EmailService
{
    /**
     * Sender address.
     *
     * @var string
     */
    private string $senderAddress;

    /**
     * Sender name.
     *
     * @var string
     */
    private string $senderName;

    /**
     * EmailService constructor.
     *
     * @param string $senderAddress
     * @param string $senderName
     */
    public function __construct(
        string $senderAddress,
        string $senderName
    ) {
        $this->senderAddress = $senderAddress;
        $this->senderName = $senderName;
    }

    /**
     * Generate the confirm mail.
     *
     * @param UserEntity $user
     *
     * @return TemplatedEmail
     */
    public function generateConfirmMail(UserEntity $user): TemplatedEmail
    {
        $templatedEmail = new TemplatedEmail();

        $templatedEmail->from(new Address($this->senderAddress, $this->senderName));
        $templatedEmail->to($user->getEmail());
        $templatedEmail->subject('Confirm your E-Mail address');
        $templatedEmail->htmlTemplate('registration/confirmation_email.html.twig');

        return $templatedEmail;
    }
}
