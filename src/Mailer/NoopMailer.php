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

use FOS\UserBundle\Model\UserInterface;

final class NoopMailer implements MailerInterface
{
    public function sendResettingEmailMessage(UserInterface $user): void
    {
    }
}
