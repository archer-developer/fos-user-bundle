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

namespace FOS\UserBundle\Tests\Doctrine;

use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Tests\App\Entity\TestUser;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use FOS\UserBundle\Util\PasswordUpdaterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class UserManagerTest extends TestCase
{
    /**
     * @var string
     */
    private const USER_CLASS = TestUser::class;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var MockObject&ObjectManager
     */
    private $om;

    /**
     * @var MockObject&ObjectRepository<TestUser>
     */
    private $repository;

    protected function setUp(): void
    {
        $passwordUpdater = $this->getMockBuilder(PasswordUpdaterInterface::class)->getMock();
        $fieldsUpdater   = $this->getMockBuilder(CanonicalFieldsUpdater::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $class            = $this->getMockBuilder(ClassMetadata::class)->getMock();
        $this->om         = $this->getMockBuilder(ObjectManager::class)->getMock();
        $this->repository = $this->getMockBuilder(ObjectRepository::class)->getMock();

        $this->om
            ->method('getRepository')
            ->with(static::equalTo(static::USER_CLASS))
            ->willReturn($this->repository)
        ;
        $this->om
            ->method('getClassMetadata')
            ->with(static::equalTo(static::USER_CLASS))
            ->willReturn($class)
        ;
        $class
            ->method('getName')
            ->willReturn(static::USER_CLASS)
        ;

        $this->userManager = new UserManager($passwordUpdater, $fieldsUpdater, $this->om, static::USER_CLASS);
    }

    public function testDeleteUser(): void
    {
        $user = $this->getUser();
        $this->om->expects(static::once())->method('remove')->with(static::equalTo($user));
        $this->om->expects(static::once())->method('flush');

        $this->userManager->deleteUser($user);
    }

    public function testGetClass(): void
    {
        static::assertSame(static::USER_CLASS, $this->userManager->getClass());
    }

    public function testFindUserBy(): void
    {
        $crit = ['foo' => 'bar'];
        $this->repository->expects(static::once())->method('findOneBy')->with(static::equalTo($crit))
            ->willReturn(null)
        ;

        $this->userManager->findUserBy($crit);
    }

    public function testFindUsers(): void
    {
        $this->repository->expects(static::once())->method('findAll')->willReturn([]);

        $this->userManager->findUsers();
    }

    public function testUpdateUser(): void
    {
        $user = $this->getUser();
        $this->om->expects(static::once())->method('persist')->with(static::equalTo($user));
        $this->om->expects(static::once())->method('flush');

        $this->userManager->updateUser($user);
    }

    private function getUser(): TestUser
    {
        $userClass = static::USER_CLASS;

        return new $userClass();
    }
}
