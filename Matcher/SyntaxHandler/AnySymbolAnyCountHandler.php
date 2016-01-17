<?php

namespace Vesax\SEOBundle\Matcher\SyntaxHandler;

/**
 * Class AnySymbolAnyCountHandler
 *
 * @package Vesax\SEOBundle\Matcher\SyntaxHandler
 * @author Artur Vesker
 */
class AnySymbolAnyCountHandler implements SyntaxHandlerInterface
{

    /**
     * @param string $pattern
     * @return string
     */
    public function handle($pattern)
    {
        return str_replace('\{\*\}', '.*', $pattern);
    }

}