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

use FOS\UserBundle\Action\CheckEmailAction;
use FOS\UserBundle\Action\RequestResetAction;
use FOS\UserBundle\Action\ResetAction;
use FOS\UserBundle\Action\SendEmailAction;
use FOS\UserBundle\EventListener\ResettingListener;
use FOS\UserBundle\Form\Model\Resetting;
use FOS\UserBundle\Form\Type\RequestPasswordFormType;
use FOS\UserBundle\Form\Type\ResettingFormType;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set(ResettingFormType::class)
            ->tag('form.type')
            ->args([
                Resetting::class,
            ])

        ->set(RequestPasswordFormType::class)
            ->tag('form.type')

        ->set(ResettingListener::class)
            ->tag('kernel.event_subscriber')
            ->args([
                new Reference('router'),
                new Parameter('FOS_user.resetting.token_ttl'),
            ])

        ->set(RequestResetAction::class)
            ->public()
            ->args([
                new Reference('twig'),
                new Reference('form.factory'),
                new Reference('router'),
            ])

        ->set(ResetAction::class)
            ->public()
            ->args([
                new Reference('twig'),
                new Reference('router'),
                new Reference('event_dispatcher'),
                new Reference('form.factory'),
                new Reference('FOS_user.user_manager'),
            ])

        ->set(SendEmailAction::class)
            ->public()
            ->args([
                new Reference('router'),
                new Reference('event_dispatcher'),
                new Reference('FOS_user.user_manager'),
                new Reference('FOS_user.util.token_generator'),
                new Reference('FOS_user.mailer'),
                new Parameter('FOS_user.resetting.retry_ttl'),
            ])

        ->set(CheckEmailAction::class)
            ->public()
            ->args([
                new Reference('twig'),
                new Reference('router'),
                new Parameter('FOS_user.resetting.retry_ttl'),
            ])

    ;
};
