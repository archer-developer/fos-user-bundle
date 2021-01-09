<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Action;

use RuntimeException;

final class LogoutAction
{
    public function __invoke(): void
    {
        throw new RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
