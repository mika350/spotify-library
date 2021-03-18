<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UserNotFoundException
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Exception
 */
class UserNotFoundException extends HttpException
{
}
