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

use FOS\UserBundle\Action\CheckLoginAction;
use FOS\UserBundle\Action\LoggedinAction;
use FOS\UserBundle\Action\LoginAction;
use FOS\UserBundle\Action\LogoutAction;
use FOS\UserBundle\EventListener\LastLoginListener;
use FOS\UserBundle\Form\Type\LoginFormType;
use FOS\UserBundle\Security\EmailProvider;
use FOS\UserBundle\Security\EmailUserProvider;
use FOS\UserBundle\Security\LoginManager;
use FOS\UserBundle\Security\LoginManagerInterface;
use FOS\UserBundle\Security\UserProvider;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set(LastLoginListener::class)
            ->tag('kernel.event_subscriber')
            ->args([
                new Reference('FOS_user.user_manager'),
            ])

        ->set('FOS_user.security.login_manager', LoginManager::class)
            ->args([
                new Reference('security.token_storage'),
                new Reference('security.user_checker'),
                new Reference('security.authentication.session_strategy'),
                new Reference('request_stack'),
                null,
            ])

        ->alias(LoginManagerInterface::class, 'FOS_user.security.login_manager')

        ->set('FOS_user.user_provider.username', UserProvider::class)
            ->args([
                new Reference('FOS_user.user_manager'),
            ])

        ->set('FOS_user.user_provider.username_email', EmailUserProvider::class)
            ->args([
                new Reference('FOS_user.user_manager'),
            ])

        ->set('FOS_user.user_provider.email', EmailProvider::class)
            ->args([
                new Reference('FOS_user.user_manager'),
            ])

        ->set(LoginFormType::class)
            ->tag('form.type')
            ->args([
                new Reference('security.authentication_utils'),
            ])

        ->set(LoginAction::class)
            ->public()
            ->args([
                new Reference('twig'),
                new Reference('event_dispatcher'),
                new Reference('form.factory'),
                new Reference('router'),
                new Reference('security.csrf.token_manager'),
            ])

        ->set(LogoutAction::class)
            ->public()

        ->set(LoggedinAction::class)
            ->public()
            ->args([
                new Reference('twig'),
                new Reference('event_dispatcher'),
                new Reference('security.helper'),
            ])

        ->set(CheckLoginAction::class)
            ->public()

    ;
};
