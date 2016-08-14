<?php

namespace Vesax\SEOBundle\Matcher\SyntaxHandler;

/**
 * Class AsteriskHandler
 *
 * @package Vesax\SEOBundle\Matcher\SyntaxHandler
 * @author Artur Vesker
 */
class AsteriskHandler implements SyntaxHandlerInterface
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