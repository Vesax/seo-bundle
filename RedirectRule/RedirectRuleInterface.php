<?php

namespace  Vesax\SEOBundle\RedirectRule;

/**
 * Interface RedirectRuleInterface
 *
 * @package Vesax\SEOBundle\RedirectRule
 */
interface RedirectRuleInterface
{

    /**
     * @return string
     */
    public function getSourceTemplate();

    /**
     * @return string
     */
    public function getDestination();

    /**
     * @return int
     */
    public function getCode();

    /**
     * @return int
     */
    public function getPriority();

    /**
     * @return bool
     */
    public function isStopped();

}