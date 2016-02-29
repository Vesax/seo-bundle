<?php

namespace Vesax\SEOBundle\Matcher;

use Vesax\SEOBundle\Matcher\SyntaxHandler\AnySymbolAnyCountHandler;
use Vesax\SEOBundle\Matcher\SyntaxHandler\SyntaxHandlerInterface;
use Vesax\SEOBundle\RedirectRule\RedirectRuleInterface;

/**
 * Class RedirectRuleMatcher
 *
 * @package Vesax\SEOBundle\Matcher
 * @author Artur Vesker
 *
 * TODO: maybe need optimization
 * TODO: tagged syntax handlers
 */
class RedirectRuleMatcher
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
     * @param RedirectRuleInterface[] $redirectRulesCollection
     * @return null|RedirectRuleInterface
     */
    public function match($path, $redirectRulesCollection)
    {
        foreach ($redirectRulesCollection as $rule) {

            $pattern = preg_quote($rule->getSourceTemplate(), '~');

            foreach ($this->syntaxHandlers as $handler) {
                $pattern = $handler->handle($pattern);
            }

            $pattern = '~\A' . $pattern . '\z~';

            if (preg_match($pattern, $path)) {
                return $rule;
            }
        }

        return null;
    }

}