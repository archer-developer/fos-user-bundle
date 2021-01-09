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

final class CheckLoginAction
{
    public function __invoke(): void
    {
        throw new RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }
}
