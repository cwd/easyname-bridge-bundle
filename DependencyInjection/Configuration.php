<?php

namespace Cwd\EasynameBridgeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('cwd_easyname_bridge')->children()
            ->variableNode('url')->defaultValue('https://api.easyname.com')->end()
            ->arrayNode('user')->isRequired()->children()
                ->scalarNode('id')->defaultValue(null)->end()
                ->scalarNode('email')->defaultValue(null)->end()
            ->end()->end()
            ->arrayNode('api')->isRequired()->children()
                ->scalarNode('key')->defaultValue(null)->end()
                ->scalarNode('authentication_salt')->defaultValue(null)->end()
                ->scalarNode('signing_salt')->defaultValue(null)->end()
            ->end()->end()
            ->booleanNode('debug')->defaultFalse()->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
