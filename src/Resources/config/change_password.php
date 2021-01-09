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

use FOS\UserBundle\Action\ChangePasswordAction;
use FOS\UserBundle\Form\Model\ChangePassword;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set(ChangePasswordFormType::class)
            ->tag('form.type')
            ->args([
                ChangePassword::class,
            ])

        ->set(ChangePasswordAction::class)
            ->public()
            ->args([
                new Reference('twig'),
                new Reference('router'),
                new Reference('security.helper'),
                new Reference('event_dispatcher'),
                new Reference('form.factory'),
                new Reference('fos_user.user_manager'),
            ])

    ;
};
