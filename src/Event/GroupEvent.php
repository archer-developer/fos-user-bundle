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

namespace FOS\UserBundle\Event;

use FOS\UserBundle\Model\GroupInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class GroupEvent extends Event
{
    /**
     * @var GroupInterface
     */
    private $group;

    /**
     * @var Request
     */
    private $request;

    public function __construct(GroupInterface $group, Request $request)
    {
        $this->group   = $group;
        $this->request = $request;
    }

    public function getGroup(): GroupInterface
    {
        return $this->group;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
