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

namespace FOS\UserBundle\Tests\Util;

use FOS\UserBundle\Tests\App\Entity\TestUser;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use FOS\UserBundle\Util\CanonicalizerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CanonicalFieldsUpdaterTest extends TestCase
{
    /**
     * @var CanonicalFieldsUpdater
     */
    private $updater;

    /**
     * @var CanonicalizerInterface&MockObject
     */
    private $usernameCanonicalizer;

    /**
     * @var CanonicalizerInterface&MockObject
     */
    private $emailCanonicalizer;

    protected function setUp(): void
    {
        $this->usernameCanonicalizer = $this->getMockCanonicalizer();
        $this->emailCanonicalizer    = $this->getMockCanonicalizer();

        $this->updater = new CanonicalFieldsUpdater($this->usernameCanonicalizer, $this->emailCanonicalizer);
    }

    public function testUpdateCanonicalFields(): void
    {
        $user = new TestUser();
        $user->setUsername('Username');
        $user->setEmail('User@Example.com');

        $this->usernameCanonicalizer->expects(static::once())
            ->method('canonicalize')
            ->with('Username')
            ->willReturnCallback('strtolower')
        ;

        $this->emailCanonicalizer->expects(static::once())
            ->method('canonicalize')
            ->with('User@Example.com')
            ->willReturnCallback('strtolower')
        ;

        $this->updater->updateCanonicalFields($user);
        static::assertSame('username', $user->getUsernameCanonical());
        static::assertSame('user@example.com', $user->getEmailCanonical());
    }

    /**
     * @return MockObject&CanonicalizerInterface
     */
    private function getMockCanonicalizer(): MockObject
    {
        return $this->getMockBuilder(CanonicalizerInterface::class)->getMock();
    }
}
