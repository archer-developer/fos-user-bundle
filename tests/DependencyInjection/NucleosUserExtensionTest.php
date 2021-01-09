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

namespace FOS\UserBundle\Tests\DependencyInjection;

use Generator;
use FOS\UserBundle\DependencyInjection\FOSUserExtension;
use FOS\UserBundle\EventListener\FlashListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Parser;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class FOSUserExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $configuration;

    public function testUserLoadThrowsExceptionUnlessDatabaseDriverIsValid(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $loader              = new FOSUserExtension();
        $config              = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load([$config], new ContainerBuilder());
    }

    public function testUserLoadThrowsExceptionUnlessFirewallNameSet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $loader = new FOSUserExtension();
        $config = $this->getEmptyConfig();
        unset($config['firewall_name']);
        $loader->load([$config], new ContainerBuilder());
    }

    public function testUserLoadThrowsExceptionUnlessGroupModelClassSet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $loader = new FOSUserExtension();
        $config = $this->getFullConfig();
        unset($config['group']['group_class']);
        $loader->load([$config], new ContainerBuilder());
    }

    public function testUserLoadThrowsExceptionUnlessUserModelClassSet(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $loader = new FOSUserExtension();
        $config = $this->getEmptyConfig();
        unset($config['user_class']);
        $loader->load([$config], new ContainerBuilder());
    }

    public function testCustomDriverWithoutManager(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $loader              = new FOSUserExtension();
        $config              = $this->getEmptyConfig();
        $config['db_driver'] = 'custom';
        $loader->load([$config], new ContainerBuilder());
    }

    public function testCustomDriver(): void
    {
        $this->configuration               = new ContainerBuilder();
        $loader                            = new FOSUserExtension();
        $config                            = $this->getEmptyConfig();
        $config['db_driver']               = 'custom';
        $config['service']['user_manager'] = 'acme.user_manager';
        $loader->load([$config], $this->configuration);

        $this->assertNotHasDefinition('FOS_user.user_manager.default');
        $this->assertAlias('acme.user_manager', 'FOS_user.user_manager');
        $this->assertParameter('custom', 'FOS_user.storage');
    }

    public function testUserLoadModelClassWithDefaults(): void
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Acme\MyBundle\Document\User', 'FOS_user.model.user.class');
    }

    public function testUserLoadModelClass(): void
    {
        $this->createFullConfiguration();

        $this->assertParameter('Acme\MyBundle\Entity\User', 'FOS_user.model.user.class');
    }

    public function testUserLoadManagerClassWithDefaults(): void
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('mongodb', 'FOS_user.storage');
        $this->assertParameter(null, 'FOS_user.model_manager_name');
        $this->assertAlias('FOS_user.user_manager.default', 'FOS_user.user_manager');
        $this->assertNotHasDefinition('FOS_user.group_manager');
    }

    public function testUserLoadManagerClass(): void
    {
        $this->createFullConfiguration();

        $this->assertParameter('orm', 'FOS_user.storage');
        $this->assertParameter('custom', 'FOS_user.model_manager_name');
        $this->assertAlias('acme_my.user_manager', 'FOS_user.user_manager');
        $this->assertAlias('FOS_user.group_manager.default', 'FOS_user.group_manager');
    }

    public function testUserLoadUtilServiceWithDefaults(): void
    {
        $this->createEmptyConfiguration();

        $this->assertAlias('FOS_user.mailer.default', 'FOS_user.mailer');
        $this->assertAlias('FOS_user.util.canonicalizer.default', 'FOS_user.util.email_canonicalizer');
        $this->assertAlias('FOS_user.util.canonicalizer.default', 'FOS_user.util.username_canonicalizer');
    }

    public function testUserLoadUtilService(): void
    {
        $this->createFullConfiguration();

        $this->assertAlias('acme_my.mailer', 'FOS_user.mailer');
        $this->assertAlias('acme_my.email_canonicalizer', 'FOS_user.util.email_canonicalizer');
        $this->assertAlias('acme_my.username_canonicalizer', 'FOS_user.util.username_canonicalizer');
    }

    public function testUserLoadFlashesByDefault(): void
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition(FlashListener::class);
    }

    public function testUserLoadFlashesCanBeDisabled(): void
    {
        $this->createFullConfiguration();

        $this->assertNotHasDefinition(FlashListener::class);
    }

    /**
     * @dataProvider userManagerSetFactoryProvider
     */
    public function testUserManagerSetFactory(string $dbDriver, string $doctrineService): void
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new FOSUserExtension();
        $config              = $this->getEmptyConfig();
        $config['db_driver'] = $dbDriver;
        $loader->load([$config], $this->configuration);

        $definition = $this->configuration->getDefinition('FOS_user.object_manager');

        $this->assertAlias($doctrineService, 'FOS_user.doctrine_registry');

        $factory = $definition->getFactory();

        static::assertIsArray($factory);
        static::assertInstanceOf(Reference::class, $factory[0]);
        static::assertSame('FOS_user.doctrine_registry', (string) $factory[0]);
        static::assertSame('getManager', $factory[1]);
    }

    /**
     * @phpstan-return Generator<array{string, string}>
     */
    public function userManagerSetFactoryProvider(): Generator
    {
        yield ['orm', 'doctrine'];
        yield ['mongodb', 'doctrine_mongodb'];
    }

    protected function createEmptyConfiguration(): void
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new FOSUserExtension();
        $config              = $this->getEmptyConfig();
        $loader->load([$config], $this->configuration);
        static::assertInstanceOf(ContainerBuilder::class, $this->configuration);
    }

    protected function createFullConfiguration(): void
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new FOSUserExtension();
        $config              = $this->getFullConfig();
        $loader->load([$config], $this->configuration);
        static::assertInstanceOf(ContainerBuilder::class, $this->configuration);
    }

    protected function getEmptyConfig(): array
    {
        $yaml = <<<'EOF'
db_driver: mongodb
firewall_name: FOS_user
user_class: Acme\MyBundle\Document\User
from_email: Acme Corp <admin@acme.org>
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function getFullConfig(): array
    {
        $yaml = <<<'EOF'
db_driver: orm
firewall_name: FOS_user
use_listener: true
use_flash_notifications: false
user_class: Acme\MyBundle\Entity\User
model_manager_name: custom
from_email: Acme Corp <admin@acme.org>
resetting:
    retry_ttl: 7200
    token_ttl: 86400
    from_email: Acme Corp <reset@acme.org>
service:
    mailer: acme_my.mailer
    email_canonicalizer: acme_my.email_canonicalizer
    username_canonicalizer: acme_my.username_canonicalizer
    user_manager: acme_my.user_manager
group:
    group_class: Acme\MyBundle\Entity\Group
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    private function assertAlias(string $value, string $key): void
    {
        static::assertSame($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }

    /**
     * @param mixed $value
     */
    private function assertParameter($value, string $key): void
    {
        static::assertSame($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    private function assertHasDefinition(string $id): void
    {
        static::assertTrue(($this->configuration->hasDefinition($id) ? true : $this->configuration->hasAlias($id)));
    }

    private function assertNotHasDefinition(string $id): void
    {
        static::assertFalse(($this->configuration->hasDefinition($id) ? true : $this->configuration->hasAlias($id)));
    }
}
