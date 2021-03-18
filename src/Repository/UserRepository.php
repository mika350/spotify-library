<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;
use function get_class;

/**
 * Class UserRepository
 *
 * @author Mika Bertels <info@bestit.de>
 * @package App\Repository
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);

        $this->setLogger(new NullLogger());
    }

    /**
     * Save an user object.
     *
     * @param BaseUserInterface $user
     *
     * @return bool
     */
    public function saveUser(UserInterface $user): bool
    {
        $success = true;

        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (ORMException $exception) {
            $this->logger->error(
                'An error occurred while updating the user.',
                [
                    'exception' => $exception,
                    'user' => $user,
                ],
            );

            $success = false;
        }

        return $success;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     *
     * @param BaseUserInterface $user
     * @param string $newEncodedPassword
     *
     * @return void
     */
    public function upgradePassword(BaseUserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $user->setPassword($newEncodedPassword);

        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (ORMException $exception) {
            $this->logger->error(
                'Error while upgrading the users password.',
                [
                    'exception' => $exception,
                    'user' => $user,
                ],
            );
        }
    }
}
