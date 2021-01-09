<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Noop\Exception;

use Exception;
use RuntimeException;

final class NoDriverException extends RuntimeException
{
    public function __construct(?string $message = null, int $code = 0, Exception $previous = null)
    {
        parent::__construct(
            null === $message ? 'The child node "db_driver" at path "FOS_user" must be configured.' : $message,
            $code,
            $previous
        );
    }
}
