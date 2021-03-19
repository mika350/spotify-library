<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\UserNotFoundException;
use App\Facade\ProfileFacade;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Controller
 */
class ProfileController extends BaseController
{
    /**
     * Instance of ProfileFacade.
     *
     * @var ProfileFacade
     */
    private ProfileFacade $profileFacade;

    /**
     * ProfileController constructor.
     *
     * @param ProfileFacade $profileFacade
     */
    public function __construct(ProfileFacade $profileFacade)
    {
        $this->profileFacade = $profileFacade;
    }

    /**
     * Profile action.
     *
     * @param string $userId
     *
     * @Route(path="/profile/{userId}", name="app_profile")
     *
     * @throws UserNotFoundException Thrown if the requested user was not found.
     *
     * @return Response
     */
    public function profileAction(string $userId): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $this->profileFacade->getUserById((int) $userId),
        ]);
    }
}
