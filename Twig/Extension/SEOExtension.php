<?php

namespace Vesax\SEOBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Vesax\SEOBundle\Entity\MetaData;
use Vesax\SEOBundle\Metadata\CompiledMetadata;
use Vesax\SEOBundle\Metadata\MetadataFactory;

/**
 * Class SEOExtension.
 *
 * @author Artur Vesker
 */
class SEOExtension extends \Twig_Extension
{

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var MetadataFactory
     */
    protected $metadataFactory;

    /**
     * @param MetadataFactory $metadataFactory
     * @param RequestStack $requestStack
     */
    public function __construct(MetadataFactory $metadataFactory, RequestStack $requestStack)
    {
        $this->metadataFactory = $metadataFactory;
        $this->requestStack = $requestStack;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('seo_extra', [$this, 'getExtra'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('seo_title', [$this, 'renderTitle'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('seo_meta_tags', [$this, 'renderMetaTags'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new \Twig_SimpleFunction('seo_load', [$this, 'getCompiledMetadata'], ['needs_context' => true]),
        ];
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'vesax_seo_extension';
    }

    /**
     * @param \Twig_Environment $environment
     * @param CompiledMetadata $compiledMetadata
     * @return string
     */
    public function renderMetaTags(\Twig_Environment $environment, CompiledMetadata $compiledMetadata = null)
    {
        if (!$compiledMetadata) {
            return null;
        }

        return $environment->render('VesaxSEOBundle:Metadata:tags.html.twig', [
            'tags' => $compiledMetadata->getMetaTags(),
            'compiledAt' => $compiledMetadata->getCompiledAt()
        ]);
    }

    /**
     * @param CompiledMetadata $compiledMetadata
     * @param null $postfix
     * @return null|string
     */
    public function renderTitle(CompiledMetadata $compiledMetadata = null, $postfix = null)
    {
        if (!$compiledMetadata) {
            return null;
        }

        if (!$title = $compiledMetadata->getTitle()) {
            return null;
        }

        if ($postfix) {
            $title .= ' - ' . $postfix;
        }

        return "<title>{$title}</title>";
    }

    /**
     * @param array $context
     * @param null $url
     * @return null|CompiledMetadata
     */
    public function getCompiledMetadata(array $context, $url = null)
    {
        return $this->metadataFactory->load($url ?: $this->requestStack->getCurrentRequest()->getUri(), $context);
    }

    /**
     * @param CompiledMetadata $compiledMetadata
     * @param $key
     * @return array|null
     */
    public function getExtra(CompiledMetadata $compiledMetadata = null, $key)
    {
        if (!$compiledMetadata) {
            return null;
        }

        return $compiledMetadata->getExtraValue($key);
    }

}
