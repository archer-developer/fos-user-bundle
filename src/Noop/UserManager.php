<?php

declare(strict_types=1);

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Noop;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManager as BaseUserManager;
use FOS\UserBundle\Noop\Exception\NoDriverException;

final class UserManager extends BaseUserManager
{
    public function deleteUser(UserInterface $user): void
    {
        throw new NoDriverException();
    }

    public function findUserBy(array $criteria): ?UserInterface
    {
        throw new NoDriverException();
    }

    public function findUsers(): array
    {
        throw new NoDriverException();
    }

    public function getClass(): string
    {
        throw new NoDriverException();
    }

    public function reloadUser(UserInterface $user): void
    {
        throw new NoDriverException();
    }

    public function updateUser(UserInterface $user, bool $andFlush = true): void
    {
        throw new NoDriverException();
    }
}
