<?php declare(strict_types=1);

namespace Fazland\ODM\ElasticaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeParentInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): NodeParentInterface
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fazland_elastica_odm');

        $this->addConnectionSection($rootNode);
        $this->addOdmSection($rootNode);

        return $treeBuilder;
    }

    private function addConnectionSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->arrayNode('connection')
                ->useAttributeAsKey('id')
                    ->children()
                        ->stringNode('url')->end()
                        ->stringNode('host')->defaultValue('localhost')->end()
                        ->integerNode('port')->defaultNull()->end()
                        ->integerNode('connect_timeout')->end()
                        ->integerNode('timeout')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addOdmSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->arrayNode('odm')
                    ->children()
                        ->stringNode('index_suffix')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
