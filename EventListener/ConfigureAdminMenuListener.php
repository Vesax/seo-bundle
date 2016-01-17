<?php

namespace Vesax\SEOBundle\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

/**
 * Class ConfigureAdminMenuListener
 *
 * @author Artur Vesker
 */
class ConfigureAdminMenuListener
{

    /**
     * @param ConfigureMenuEvent $event
     */
    public function configureMenu(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        if (!$seo = $menu->getChild('SEO')) {
            return;
        }

        $seo->addChild('Настройки robots', ['route' => 'vesax.seo.admin.robots.edit']);
    }

}