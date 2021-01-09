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

namespace FOS\UserBundle\Tests\App\Entity;

use FOS\UserBundle\Model\User;

/**
 * @phpstan-extends User<\FOS\UserBundle\Model\GroupInterface>
 */
class TestUser extends User
{
    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
