<?php

namespace Vesax\SEOBundle\Metadata\Compiler;

use Vesax\SEOBundle\Metadata\CompiledMetadata;
use Vesax\SEOBundle\Rule\RuleInterface;

/**
 * Interface CompilerInterface
 *
 * @package Vesax\SEOBundle\Metadata\Compiler
 */
interface CompilerInterface
{

    /**
     * @param RuleInterface $rule
     * @param array $context
     * @return CompiledMetadata
     */
    public function compileMetadata(RuleInterface $rule, array $context);

}