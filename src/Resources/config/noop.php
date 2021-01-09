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

use FOS\UserBundle\Noop\UserListener;
use FOS\UserBundle\Noop\UserManager;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set('FOS_user.user_manager.default', UserManager::class)
            ->args([
                new Reference('FOS_user.util.password_updater'),
                new Reference('FOS_user.util.canonical_fields_updater'),
            ])

        ->set('FOS_user.user_listener', UserListener::class)

    ;
};
