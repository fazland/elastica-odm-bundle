<?php declare(strict_types=1);

namespace Fazland\ODM\ElasticaBundle\DependencyInjection\Compiler;

use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class DebugPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (! $container->getParameter('kernel.debug')) {
            return;
        }

        $container->register('fazland_elastica_odm.metadata_cache', ArrayAdapter::class);
    }
}
