<?php declare(strict_types=1);

namespace Fazland\ODM\ElasticaBundle\DependencyInjection\Compiler;

use Fazland\ODM\Elastica\Type\TypeManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class AddElasticaTypesCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $typeManagerDef = $container->getDefinition(TypeManager::class);
        foreach ($container->findTaggedServiceIds('elastica.type') as $serviceId => $tag) {
            $typeManagerDef->addMethodCall('addType', [new Reference($serviceId)]);
        }
    }
}
