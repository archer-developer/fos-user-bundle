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

namespace FOS\UserBundle\Tests\Mailer;

use FOS\UserBundle\Mailer\Mailer;
use FOS\UserBundle\Model\UserInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class MailerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var ObjectProphecy<SymfonyMailer>
     */
    private $swiftMailer;

    /**
     * @var ObjectProphecy<TranslatorInterface>
     */
    private $translator;

    /**
     * @var ObjectProphecy<UrlGeneratorInterface>
     */
    private $generator;

    protected function setUp(): void
    {
        $this->swiftMailer = $this->prophesize(SymfonyMailer::class);
        $this->translator  = $this->prophesize(TranslatorInterface::class);
        $this->generator   = $this->prophesize(UrlGeneratorInterface::class);
    }

    public function testSendResettingEmail(): void
    {
        $mailer = $this->getMailer();

        $this->translator->trans(Argument::any(), Argument::any(), Argument::any())
            ->willReturnArgument(0)
        ;

        $this->generator->generate(Argument::any(), Argument::any(), Argument::any())
            ->willReturn('http://something.local')
        ;

        $this->swiftMailer->send(Argument::type(TemplatedEmail::class))
            ->shouldBeCalled()
        ;

        $mailer->sendResettingEmailMessage($this->getUser());
    }

    private function getMailer(): Mailer
    {
        return new Mailer(
            $this->swiftMailer->reveal(),
            $this->translator->reveal(),
            $this->generator->reveal(),
            'foo@example.com'
        );
    }

    /**
     * @return UserInterface&MockObject
     */
    private function getUser(): MockObject
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $user->method('getEmail')
            ->willReturn('foo@bar.baz')
        ;

        return $user;
    }
}
