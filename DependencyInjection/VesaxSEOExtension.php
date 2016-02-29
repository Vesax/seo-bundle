<?php

namespace Vesax\SEOBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class VesaxSEOExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['cache']) {
            $container->setAlias('vesax.seo.metadata_cache', 'doctrine_cache.providers.' . $config['cache']);
        }

        if ($config['redirects']) {
            $container->setDefinition('vesax.seo.redirect_matcher', new Definition('Vesax\SEOBundle\Matcher\RedirectRuleMatcher'));

            $redirectListenerDefinition = new Definition('Vesax\SEOBundle\EventListener\RedirectListener', [
                new Reference('vesax.seo.redirect_rule_repository'),
                new Reference('vesax.seo.redirect_matcher'),
                new Reference('vesax.seo.metadata_cache', ContainerInterface::NULL_ON_INVALID_REFERENCE)
            ]);

            $redirectListenerDefinition->addTag('kernel.event_subscriber');

            $container->setDefinition('vesax.seo.redirect_listener', $redirectListenerDefinition);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
