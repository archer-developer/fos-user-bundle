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

namespace FOS\UserBundle\Util;

use FOS\UserBundle\Model\UserInterface;

class CanonicalFieldsUpdater
{
    /**
     * @var CanonicalizerInterface
     */
    private $usernameCanonicalizer;

    /**
     * @var CanonicalizerInterface
     */
    private $emailCanonicalizer;

    public function __construct(CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer)
    {
        $this->usernameCanonicalizer = $usernameCanonicalizer;
        $this->emailCanonicalizer    = $emailCanonicalizer;
    }

    public function updateCanonicalFields(UserInterface $user): void
    {
        $usernameCanonical = $this->canonicalizeUsername($user->getUsername());

        if ('' !== $usernameCanonical) {
            $user->setUsernameCanonical($usernameCanonical);
        }

        $emailCanonical = $this->canonicalizeEmail($user->getEmail());

        if ('' !== $emailCanonical) {
            $user->setEmailCanonical($emailCanonical);
        }
    }

    public function canonicalizeEmail(?string $email): string
    {
        return $this->emailCanonicalizer->canonicalize($email);
    }

    public function canonicalizeUsername(?string $username): string
    {
        return $this->usernameCanonicalizer->canonicalize($username);
    }
}
