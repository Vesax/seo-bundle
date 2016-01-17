<?php

namespace Vesax\SEOBundle\Rule;

use Vesax\SEOBundle\Metadata\MetaTagInterface;

/**
 * Interface RuleInterface
 *
 * @package Vesax\SEOBundle\Rule
 */
interface RuleInterface
{

    /**
     * @return string
     */
    public function getPattern();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return MetaTagInterface[]
     */
    public function getMetaTags();

    /**
     * @return array
     */
    public function getExtra();

}