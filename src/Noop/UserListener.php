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

use Doctrine\Common\EventSubscriber;

final class UserListener implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
        ];
    }
}
