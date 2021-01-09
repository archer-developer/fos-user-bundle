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

use FOS\UserBundle\EventListener\AuthenticationListener;
use FOS\UserBundle\EventListener\LocaleEventListener;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set(AuthenticationListener::class)
            ->tag('kernel.event_subscriber')
            ->args([
                new Reference('fos_user.security.login_manager'),
                new Parameter('fos_user.firewall_name'),
            ])

        ->set(LocaleEventListener::class)
            ->tag('kernel.event_subscriber')
            ->args([
                new Reference('translator'),
                new Reference('twig'),
            ])

    ;
};
