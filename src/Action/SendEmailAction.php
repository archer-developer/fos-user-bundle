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

use DateTime;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class SendEmailAction
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var int
     */
    private $retryTtl;

    /**
     * SendEmailAction constructor.
     */
    public function __construct(
        RouterInterface $router,
        EventDispatcherInterface $eventDispatcher,
        UserManagerInterface $userManager,
        TokenGeneratorInterface $tokenGenerator,
        MailerInterface $mailer,
        int $retryTtl
    ) {
        $this->router          = $router;
        $this->eventDispatcher = $eventDispatcher;
        $this->userManager     = $userManager;
        $this->tokenGenerator  = $tokenGenerator;
        $this->mailer          = $mailer;
        $this->retryTtl        = $retryTtl;
    }

    public function __invoke(Request $request): Response
    {
        $username = $request->request->get('username');

        $user = null === $username ? null : $this->userManager->findUserByUsernameOrEmail($username);

        if (null !== $user) {
            $response = $this->process($request, $user);

            if (null !== $response) {
                return $response;
            }
        }

        return new RedirectResponse($this->router->generate('FOS_user_resetting_check_email', [
            'username' => $username,
        ]));
    }

    /**
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function process(Request $request, UserInterface $user): ?Response
    {
        $event = new GetResponseNullableUserEvent($user, $request);
        $this->eventDispatcher->dispatch($event, FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if ($user->isPasswordRequestNonExpired($this->retryTtl)) {
            return null;
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch($event, FOSUserEvents::RESETTING_RESET_REQUEST);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch($event, FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $this->mailer->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new DateTime());
        $this->userManager->updateUser($user);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch($event, FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        return null;
    }
}
