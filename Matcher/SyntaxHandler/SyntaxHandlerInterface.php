<?php

namespace Vesax\SEOBundle\Matcher\SyntaxHandler;

/**
 * Interface SyntaxHandlerInterface
 *
 * @package Vesax\SEOBundle\Matcher\SyntaxHandler
 */
interface SyntaxHandlerInterface
{

    /**
     * @param string $pattern
     * @return string
     */
    public function handle($pattern);

}