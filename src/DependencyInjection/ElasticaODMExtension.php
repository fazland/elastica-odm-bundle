<?php declare(strict_types=1);

namespace Fazland\ODM\ElasticaBundle\DependencyInjection;

use Fazland\ODM\Elastica\Annotation;
use Fazland\ODM\Elastica\Metadata\Processor;
use Kcs\Metadata\Loader\Processor\ProcessorFactory;
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
        $loader->load('types.xml');
        $loader->load('collector.xml');
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

        $annotationFactory = $container->findDefinition('fazland_elastica_odm.annotation_processor_factory');
        if (\method_exists(ProcessorFactory::class, 'registerProcessors')) {
            $processorRefl = new \ReflectionClass(Processor\IndexProcessor::class);
            $annotationFactory->addMethodCall('registerProcessors', [ \dirname($processorRefl->getFileName()) ]);
        } else {
            $annotationFactory->addMethodCall('registerProcessor', [ Annotation\Document::class, Processor\DocumentProcessor::class ]);
            $annotationFactory->addMethodCall('registerProcessor', [ Annotation\DocumentId::class, Processor\DocumentIdProcessor::class ]);
            $annotationFactory->addMethodCall('registerProcessor', [ Annotation\IndexName::class, Processor\IndexNameProcessor::class ]);
            $annotationFactory->addMethodCall('registerProcessor', [ Annotation\Index::class, Processor\IndexProcessor::class ]);
            $annotationFactory->addMethodCall('registerProcessor', [ Annotation\TypeName::class, Processor\TypeNameProcessor::class ]);
            $annotationFactory->addMethodCall('registerProcessor', [ Annotation\Field::class, Processor\FieldProcessor::class ]);
            if (\class_exists(Annotation\Setting::class)) {
                $annotationFactory->addMethodCall('registerProcessor', [Annotation\Setting::class, Processor\SettingProcessor::class]);
            }
        }
    }
}
