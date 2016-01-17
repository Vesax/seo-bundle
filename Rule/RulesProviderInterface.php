<?php

namespace Vesax\SEOBundle\Rule;

/**
 * Interface RulesProviderInterface
 *
 * @package Vesax\SEOBundle\Rule
 */
interface RulesProviderInterface
{

    /**
     * @return RuleInterface[]
     */
    public function load();

}