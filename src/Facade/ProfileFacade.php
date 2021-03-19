<?php

declare(strict_types=1);

namespace App\Facade;

use App\Entity\User\UserEntity;
use App\Exception\UserNotFoundException;
use App\Service\UserService;

/**
 * Class ProfileFacade
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Facade
 */
class ProfileFacade
{
    /**
     * Instance of UserService.
     *
     * @var UserService
     */
    private UserService $userService;

    /**
     * ProfileFacade constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get an user by id.
     *
     * @param int $userId
     *
     * @throws UserNotFoundException Thrown if the user was not found.
     *
     * @return UserEntity
     */
    public function getUserById(int $userId): UserEntity
    {
        $user = $this->userService->searchById($userId);

        if ($user === null) {
            throw new UserNotFoundException(404, sprintf('The user with id %s was not found.', (string) $userId));
        }

        assert($user instanceof UserEntity);

        return $user;
    }
}
