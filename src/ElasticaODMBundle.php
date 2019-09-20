<?php declare(strict_types=1);

namespace Fazland\ODM\ElasticaBundle;

use Fazland\ODM\Elastica\Type\TypeInterface;
use Fazland\ODM\ElasticaBundle\DependencyInjection\Compiler\AddElasticaTypesCompilerPass;
use Fazland\ODM\ElasticaBundle\DependencyInjection\Compiler\DebugPass;
use Fazland\ODM\ElasticaBundle\DependencyInjection\Compiler\FixturesCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ElasticaODMBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(TypeInterface::class)
            ->addTag('elastica.type');

        $container
            ->addCompilerPass(new AddElasticaTypesCompilerPass())
            ->addCompilerPass(new FixturesCompilerPass())
            ->addCompilerPass(new DebugPass())
        ;
    }
}
