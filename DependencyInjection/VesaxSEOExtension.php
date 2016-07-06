<?php

namespace Vesax\SEOBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Vesax\SEOBundle\Entity\Rule;

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

        if ($config['redirects']['enabled']) {
            $container->setDefinition('vesax.seo.redirect_matcher', new Definition('Vesax\SEOBundle\Matcher\RedirectRuleMatcher'));

            $redirectListenerDefinition = new Definition('Vesax\SEOBundle\EventListener\RedirectListener', [
                new Reference('vesax.seo.redirect_rule_repository'),
                new Reference('vesax.seo.redirect_matcher'),
                new Reference('vesax.seo.metadata_cache', ContainerInterface::NULL_ON_INVALID_REFERENCE)
            ]);

            $redirectListenerDefinition->addTag('kernel.event_listener', ['event' => 'kernel.exception', 'method' => 'onException']);

            if (!$config['redirects']['not_found_only']) {
                $redirectListenerDefinition->addTag('kernel.event_listener', ['event' => 'kernel.request', 'method' => 'onRequest']);
            }
            
            $container->setDefinition('vesax.seo.redirect_listener', $redirectListenerDefinition);

            $redirectAdminDefinition = new Definition('Vesax\SEOBundle\Admin\RedirectRuleAdmin', [
                null,
                "Vesax\\SEOBundle\\Entity\\RedirectRule",
                "SonataAdminBundle:CRUD"
            ]);

            $redirectAdminDefinition
                ->addTag('sonata.admin', ['manager_type' => 'orm', 'group' => 'SEO', 'label' => 'Redirect Rules']);

            $container->setDefinition('vesax.seo.admin.rediect_rule', $redirectAdminDefinition);
        }

        if ($config['robots']) {
            $menuListenerDefinition = new Definition('Vesax\SEOBundle\EventListener\ConfigureAdminMenuListener');
            $menuListenerDefinition->addTag('kernel.event_listener', [
                'event' => 'sonata.admin.event.configure.menu.sidebar',
                'method' => 'configureMenu'
            ]);

            $container->setDefinition('vesax.seo.admin.menu_listener', $menuListenerDefinition);
        }

        if ($config['meta']) {
            $metaAdminDefinition = new Definition('Vesax\SEOBundle\Admin\RuleAdmin', [
                null,
                Rule::class,
                'SonataAdminBundle:CRUD'
            ]);

            $metaAdminDefinition->addTag('sonata.admin', [
                'manager_type' => 'orm',
                'group' => 'SEO',
                'label' => 'Page Rules'
            ]);

            $container->setDefinition('vesax.seo.admin.rule', $metaAdminDefinition);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
