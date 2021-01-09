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

namespace FOS\UserBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
use FOS\UserBundle\DependencyInjection\Compiler\InjectRememberMeServicesPass;
use FOS\UserBundle\DependencyInjection\Compiler\InjectUserCheckerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FOSUserBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new InjectUserCheckerPass());
        $container->addCompilerPass(new InjectRememberMeServicesPass());

        $this->addRegisterMappingsPass($container);
    }

    private function addRegisterMappingsPass(ContainerBuilder $container): void
    {
        $mappings = [
            (string) realpath(__DIR__.'/Resources/config/doctrine-mapping') => 'FOS\UserBundle\Model',
        ];

        if (class_exists(DoctrineOrmMappingsPass::class)) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, ['fos_user.model_manager_name'], 'fos_user.backend_type_orm'));
        }

        if (class_exists(DoctrineMongoDBMappingsPass::class)) {
            $container->addCompilerPass(DoctrineMongoDBMappingsPass::createXmlMappingDriver($mappings, ['fos_user.model_manager_name'], 'fos_user.backend_type_mongodb'));
        }
    }
}
