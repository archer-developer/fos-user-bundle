<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Mailer\Mail;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;

final class ResettingMail extends TemplatedEmail
{
    /**
     * @var string
     */
    private $confirmationUrl;

    /**
     * @var UserInterface
     */
    private $user;

    public function __construct(Headers $headers = null, AbstractPart $body = null)
    {
        parent::__construct($headers, $body);

        $this->htmlTemplate('@FOSUser/Resetting/email.txt.twig');
    }

    public function setConfirmationUrl(string $confirmationUrl): self
    {
        $this->confirmationUrl = $confirmationUrl;

        return $this;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getConfirmationUrl(): string
    {
        return $this->confirmationUrl;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return array<mixed>
     */
    public function getContext(): array
    {
        return array_merge([
            'user'             => $this->getUser(),
            'confirmationUrl'  => $this->getConfirmationUrl(),
        ], parent::getContext());
    }
}
