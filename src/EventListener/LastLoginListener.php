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

namespace FOS\UserBundle\EventListener;

use DateTime;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

final class LastLoginListener implements EventSubscriberInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin',
            SecurityEvents::INTERACTIVE_LOGIN          => 'onSecurityInteractiveLogin',
        ];
    }

    public function onImplicitLogin(UserEvent $event): void
    {
        $user = $event->getUser();

        $user->setLastLogin(new DateTime());
        $this->userManager->updateUser($user);
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof UserInterface) {
            $user->setLastLogin(new DateTime());
            $this->userManager->updateUser($user);
        }
    }
}
