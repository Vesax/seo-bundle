<?php

namespace Vesax\SEOBundle\Metadata;

/**
 * Interface MetaTagInterface
 *
 * @package Vesax\SEOBundle\Metadata
 */
interface MetaTagInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getProperty();

    /**
     * @return string
     */
    public function getContent();

}