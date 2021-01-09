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

use Doctrine\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserListener;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set('FOS_user.user_manager.default', UserManager::class)
            ->args([
                new Reference('FOS_user.util.password_updater'),
                new Reference('FOS_user.util.canonical_fields_updater'),
                new Reference('FOS_user.object_manager'),
                new Parameter('FOS_user.model.user.class'),
            ])

        // The factory is configured in the DI extension class to support more Symfony versions
        ->set('FOS_user.object_manager', ObjectManager::class)
            ->args([
                new Parameter('FOS_user.model_manager_name'),
            ])

        ->set('FOS_user.user_listener', UserListener::class)
            ->args([
                new Reference('FOS_user.util.password_updater'),
                new Reference('FOS_user.util.canonical_fields_updater'),
            ])

    ;
};
