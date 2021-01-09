<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use FOS\UserBundle\Util\Canonicalizer;
use FOS\UserBundle\Util\PasswordUpdater;
use FOS\UserBundle\Util\PasswordUpdaterInterface;
use FOS\UserBundle\Util\TokenGenerator;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set('FOS_user.util.canonicalizer.default', Canonicalizer::class)

        ->set('FOS_user.util.user_manipulator', UserManipulator::class)
            ->args([
                new Reference('FOS_user.user_manager'),
                new Reference('event_dispatcher'),
                new Reference('request_stack'),
            ])

        ->set('FOS_user.util.token_generator.default', TokenGenerator::class)

        ->alias(TokenGeneratorInterface::class, 'FOS_user.util.token_generator')

        ->set('FOS_user.util.password_updater', PasswordUpdater::class)
            ->args([
                new Reference('security.encoder_factory'),
            ])

        ->alias(PasswordUpdaterInterface::class, 'FOS_user.util.password_updater')

        ->set('FOS_user.util.canonical_fields_updater', CanonicalFieldsUpdater::class)
            ->args([
                new Reference('FOS_user.util.username_canonicalizer'),
                new Reference('FOS_user.util.email_canonicalizer'),
            ])

        ->alias(CanonicalFieldsUpdater::class, 'FOS_user.util.canonical_fields_updater')

        ->alias(UserManagerInterface::class, 'FOS_user.user_manager')

    ;
};
