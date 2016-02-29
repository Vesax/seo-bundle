<?php

namespace Vesax\SEOBundle\RedirectRule;

/**
 * Interface RedirectRuleRepositoryInterface
 *
 * @package Vesax\SEOBundle\RedirectRule
 */
interface RedirectRuleRepositoryInterface
{

    /**
     * @return RedirectRuleInterface[]
     */
    public function findAllSortedByPriority();

}