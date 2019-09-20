<?php declare(strict_types=1);

namespace Fazland\ODM\ElasticaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Parameter;

class ElasticaODMExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader($container, new FileLocator([__DIR__.'/../Resources/config']));

        $loader->load('odm.xml');
        if (\class_exists(Application::class)) {
            $loader->load('console.xml');
        }

        $definition = $container->getDefinition('fazland_elastica_odm.metadata_loader');
        $definition->replaceArgument(1, $config['odm']['mappings']['prefix_dir']);

        $container->setParameter('fazland_elastica_odm.connection.url', $container->resolveEnvPlaceholders($config['connection']['url']));
        $container->setParameter('fazland_elastica_odm.connection.connect_timeout', $config['connection']['connect_timeout']);
        $container->setParameter('fazland_elastica_odm.connection.timeout', $config['connection']['timeout']);

        $container->setParameter('fazland_elastica_odm.odm.index_suffix', $config['odm']['index_suffix']);

        $container->getDefinition('fazland_elastica_odm.metadata_cache')
            ->replaceArgument(2, new Parameter('container.build_id'));
    }
}
