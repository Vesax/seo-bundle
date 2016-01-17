<?php

namespace Vesax\SEOBundle\Matcher;

use Vesax\SEOBundle\Matcher\SyntaxHandler\AnySymbolAnyCountHandler;
use Vesax\SEOBundle\Matcher\SyntaxHandler\SyntaxHandlerInterface;
use Vesax\SEOBundle\Rule\RuleInterface;

/**
 * Class RuleMatcher
 *
 * @package Vesax\SEOBundle\Matcher
 * @author Artur Vesker
 *
 * TODO: maybe need optimization
 * TODO: tagged syntax handlers
 */
class RuleMatcher
{

    /**
     * @var SyntaxHandlerInterface[]
     */
    protected $syntaxHandlers = [];

    public function __construct()
    {
        $this->syntaxHandlers[] = new AnySymbolAnyCountHandler();
    }

    /**
     * @param string $path
     * @param RuleInterface[] $metadataCollection
     * @return null|RuleInterface
     */
    public function match($path, $metadataCollection)
    {
        foreach ($metadataCollection as $metadata) {

            $pattern = preg_quote($metadata->getPattern(), '~');

            foreach ($this->syntaxHandlers as $handler) {
                $pattern = $handler->handle($pattern);
            }

            $pattern = '~\A' . $pattern . '\z~';

            if (preg_match($pattern, $path)) {
                return $metadata;
            }
        }

        return null;
    }

}