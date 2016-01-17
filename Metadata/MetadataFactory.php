<?php

namespace Vesax\SEOBundle\Metadata;

use Doctrine\Common\Cache\Cache;
use Vesax\SEOBundle\Matcher\RuleMatcher;
use Vesax\SEOBundle\Metadata\Compiler\CompilerInterface;
use Vesax\SEOBundle\Model\MetaTag;
use Vesax\SEOBundle\Rule\RulesProviderInterface;

/**
 * Class MetadataFactory
 *
 * @package Vesax\SEOBundle\Metadata
 * @author Artur Vesker
 */
class MetadataFactory
{

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var RulesProviderInterface
     */
    protected $provider;

    /**
     * @var CompilerInterface
     */
    protected $compiler;

    /**
     * @var RuleMatcher
     */
    protected $matcher;

    /**
     * @param RulesProviderInterface $provider
     * @param CompilerInterface $compiler
     * @param Cache|null $cache
     */
    public function __construct(RulesProviderInterface $provider, CompilerInterface $compiler, Cache $cache = null)
    {
        $this->cache = $cache;
        $this->provider = $provider;
        $this->compiler = $compiler;
        $this->matcher = new RuleMatcher();
    }

    /**
     * @param $url
     * @param array $context
     * @return null|CompiledMetadata
     */
    public function load($url, array $context)
    {
        if ($this->cache) {
            if ($cachedMetadata = $this->cache->fetch($url)) {
                return $cachedMetadata;
            }
        }

        $path = $this->extractPath($url);

        $rule = $this->matcher->match($path, $this->provider->load());

        if (!$rule) {
            return null;
        }

        $compiledMetadata = $this->compiler->compileMetadata($rule, $context);

        if ($this->cache) {
            $this->cache->save($url, $compiledMetadata);
        }

        return $compiledMetadata;
    }

    /**
     * @param $url
     * @return string
     */
    public function extractPath($url)
    {
        $normalized = parse_url($url, PHP_URL_PATH);

        if (strpos($normalized, '/app_dev.php') !== false) {
            $normalized = substr($normalized, 12);
        }

        if ($query = parse_url($url, PHP_URL_QUERY)) {
            $normalized .= '?' . $query;
        }

        return $normalized;
    }

    /**
     * @param MetaTag[] $tags
     * @param array $context
     * @return array
     */
    private function renderMetaTags(array $tags, array $context)
    {
/*        foreach ($tags as $tag) {
            $tag->content = $this->twig->createTemplate($tag->content)->render($context);
        }

        return $this->twig->render('VesaxSEOBundle:Metadata:tags.html.twig', ['tags' => $this->renderMetaTags($tags, $context)]);*/
    }

}