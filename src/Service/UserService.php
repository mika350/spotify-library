<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\UserInterface;
use App\Repository\UserRepository;

/**
 * Class UserService
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Service
 */
class UserService
{
    /**
     * Instance of UserRepository.
     *
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Save an user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function saveUser(UserInterface $user): void
    {
        $this->userRepository->saveUser($user);
    }

    /**
     * Search an user by identifier.
     *
     * @param int $id
     *
     * @return UserInterface
     */
    public function searchById(int $id): UserInterface
    {
        return $this->userRepository->find($id);
    }
}