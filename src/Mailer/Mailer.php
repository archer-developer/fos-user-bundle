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

namespace FOS\UserBundle\Mailer;

use FOS\UserBundle\Mailer\Mail\ResettingMail;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class Mailer implements MailerInterface
{
    /**
     * @var SymfonyMailer
     */
    private $mailer;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var string
     */
    private $fromEmail;

    public function __construct(SymfonyMailer $mailer, TranslatorInterface $translator, UrlGeneratorInterface $router, string $fromEmail)
    {
        $this->mailer     = $mailer;
        $this->translator = $translator;
        $this->router     = $router;
        $this->fromEmail  = $fromEmail;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendResettingEmailMessage(UserInterface $user): void
    {
        $url  = $this->router->generate('FOS_user_resetting_reset', [
            'token' => $user->getConfirmationToken(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $mail = (new ResettingMail())
            ->from(Address::fromString($this->fromEmail))
            ->to(new Address($user->getEmail()))
            ->subject($this->translator->trans('resetting.email.subject', [
                '%username%' => $user->getUsername(),
            ], 'FOSUserBundle'))
            ->setUser($user)
            ->setConfirmationUrl($url)
        ;

        $this->mailer->send($mail);
    }
}
