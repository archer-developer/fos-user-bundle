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

use InvalidArgumentException;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\Translation\TranslatorInterface;

final class FlashListener implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private static $successMessages = [
        FOSUserEvents::CHANGE_PASSWORD_COMPLETED => 'change_password.flash.success',
        FOSUserEvents::RESETTING_RESET_COMPLETED => 'resetting.flash.success',
    ];

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(FlashBagInterface $flashBag, TranslatorInterface $translator)
    {
        $this->flashBag   = $flashBag;
        $this->translator = $translator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FOSUserEvents::CHANGE_PASSWORD_COMPLETED => 'addSuccessFlash',
            FOSUserEvents::RESETTING_RESET_COMPLETED => 'addSuccessFlash',
        ];
    }

    public function addSuccessFlash(Event $event, string $eventName): void
    {
        if (!isset(self::$successMessages[$eventName])) {
            throw new InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->flashBag->add('success', $this->trans(self::$successMessages[$eventName]));
    }

    private function trans(string $message, array $params = []): string
    {
        return $this->translator->trans($message, $params, 'FOSUserBundle');
    }
}
