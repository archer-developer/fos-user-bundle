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

namespace FOS\UserBundle\Tests\Security;

use FOS\UserBundle\Model\User;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Security\EmailUserProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

final class EmailUserProviderTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $userManager;

    /**
     * @var EmailUserProvider
     */
    private $userProvider;

    protected function setUp(): void
    {
        $this->userManager  = $this->getMockBuilder(UserManagerInterface::class)->getMock();
        $this->userProvider = new EmailUserProvider($this->userManager);
    }

    public function testLoadUserByUsername(): void
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $this->userManager->expects(static::once())
            ->method('findUserByUsernameOrEmail')
            ->with('foobar')
            ->willReturn($user)
        ;

        static::assertSame($user, $this->userProvider->loadUserByUsername('foobar'));
    }

    public function testLoadUserByInvalidUsername(): void
    {
        $this->expectException(UsernameNotFoundException::class);

        $this->userManager->expects(static::once())
            ->method('findUserByUsernameOrEmail')
            ->with('foobar')
            ->willReturn(null)
        ;

        $this->userProvider->loadUserByUsername('foobar');
    }

    public function testRefreshUserBy(): void
    {
        $user = $this->getMockBuilder(User::class)
                    ->setMethods(['getId'])
                    ->getMock()
        ;

        $user->expects(static::once())
            ->method('getId')
            ->willReturn('123')
        ;

        $refreshedUser = $this->getMockBuilder(UserInterface::class)->getMock();
        $this->userManager->expects(static::once())
            ->method('findUserBy')
            ->with(['id' => '123'])
            ->willReturn($refreshedUser)
        ;

        $this->userManager->expects(static::atLeastOnce())
            ->method('getClass')
            ->willReturn(\get_class($user))
        ;

        static::assertSame($refreshedUser, $this->userProvider->refreshUser($user));
    }

    public function testRefreshInvalidUser(): void
    {
        $this->expectException(UnsupportedUserException::class);

        $user = $this->getMockBuilder(SymfonyUserInterface::class)->getMock();

        $this->userProvider->refreshUser($user);
    }
}
