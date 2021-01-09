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

use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\GroupManager as BaseGroupManager;
use FOS\UserBundle\Noop\Exception\NoDriverException;

/**
 * @phpstan-template GroupTemplate of \FOS\UserBundle\Model\GroupInterface
 * @phpstan-extends \FOS\UserBundle\Model\GroupManager<GroupTemplate>
 */
final class GroupManager extends BaseGroupManager
{
    public function deleteGroup(GroupInterface $group): void
    {
        throw new NoDriverException();
    }

    public function findGroupBy(array $criteria): ?GroupInterface
    {
        throw new NoDriverException();
    }

    public function findGroups(): array
    {
        throw new NoDriverException();
    }

    public function getClass(): string
    {
        throw new NoDriverException();
    }

    public function updateGroup(GroupInterface $group, bool $andFlush = true): void
    {
        throw new NoDriverException();
    }
}
