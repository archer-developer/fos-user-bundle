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

use FOS\UserBundle\Command\ActivateUserCommand;
use FOS\UserBundle\Command\ChangePasswordCommand;
use FOS\UserBundle\Command\CreateUserCommand;
use FOS\UserBundle\Command\DeactivateUserCommand;
use FOS\UserBundle\Command\DemoteUserCommand;
use FOS\UserBundle\Command\PromoteUserCommand;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set(ActivateUserCommand::class)
            ->tag('console.command', [
                'command' => 'FOS:user:activate',
            ])
            ->args([
                new Reference('FOS_user.util.user_manipulator'),
            ])

        ->set(ChangePasswordCommand::class)
            ->tag('console.command', [
                'command' => 'FOS:user:change-password',
            ])
            ->args([
                new Reference('FOS_user.util.user_manipulator'),
            ])

        ->set(CreateUserCommand::class)
            ->tag('console.command', [
                'command' => 'FOS:user:create',
            ])
            ->args([
                new Reference('FOS_user.util.user_manipulator'),
            ])

        ->set(DeactivateUserCommand::class)
            ->tag('console.command', [
                'command' => 'FOS:user:deactivate',
            ])
            ->args([
                new Reference('FOS_user.util.user_manipulator'),
            ])

        ->set(DemoteUserCommand::class)
            ->tag('console.command', [
                'command' => 'FOS:user:demote',
            ])
            ->args([
                new Reference('FOS_user.util.user_manipulator'),
            ])

        ->set(PromoteUserCommand::class)
            ->tag('console.command', [
                'command' => 'FOS:user:promote',
            ])
            ->args([
                new Reference('FOS_user.util.user_manipulator'),
            ])

    ;
};
