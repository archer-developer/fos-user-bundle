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

namespace FOS\UserBundle\Tests\Command;

use FOS\UserBundle\Command\ChangePasswordCommand;
use FOS\UserBundle\Util\UserManipulator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;

final class ChangePasswordCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $commandTester = $this->createCommandTester($this->getManipulator('user', 'pass'));
        $exitCode      = $commandTester->execute([
            'username' => 'user',
            'password' => 'pass',
        ], [
            'decorated'   => false,
            'interactive' => false,
        ]);

        static::assertSame(0, $exitCode, 'Returns 0 in case of success');
        static::assertMatchesRegularExpression('/Changed password for user user/', $commandTester->getDisplay());
    }

    public function testExecuteInteractiveWithQuestionHelper(): void
    {
        $application = new Application();

        $helper = $this->getMockBuilder(QuestionHelper::class)
            ->setMethods(['ask'])
            ->getMock()
        ;

        $helper->expects(static::exactly(2))
            ->method('ask')
            ->willReturn(
                'user',
                'pass'
            )
        ;

        $application->getHelperSet()->set($helper, 'question');

        $commandTester = $this->createCommandTester($this->getManipulator('user', 'pass'), $application);
        $exitCode      = $commandTester->execute([], [
            'decorated'   => false,
            'interactive' => true,
        ]);

        static::assertSame(0, $exitCode, 'Returns 0 in case of success');
        static::assertMatchesRegularExpression('/Changed password for user user/', $commandTester->getDisplay());
    }

    private function createCommandTester(UserManipulator $userManipulator, Application $application = null): CommandTester
    {
        if (null === $application) {
            $application = new Application();
        }

        $application->setAutoExit(false);

        $command = new ChangePasswordCommand($userManipulator);

        $application->add($command);

        return new CommandTester($application->find('FOS:user:change-password'));
    }

    /**
     * @return MockObject&UserManipulator
     */
    private function getManipulator(string $username, string $password): MockObject
    {
        $manipulator = $this->getMockBuilder(UserManipulator::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $manipulator
            ->expects(static::once())
            ->method('changePassword')
            ->with($username, $password)
        ;

        return $manipulator;
    }
}
