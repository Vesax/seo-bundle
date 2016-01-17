<?php

namespace Vesax\SEOBundle\Metadata;

/**
 * Class CompiledMetadata
 *
 * @author Artur Vesker
 */
class CompiledMetadata
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var CompiledMetaTag[]
     */
    protected $metaTags;

    /**
     * @var array
     */
    protected $extra;

    /**
     * @var string
     */
    protected $compiledAt;

    /**
     * CompiledMetadata constructor.
     *
     * @param string $title
     * @param CompiledMetaTag[] $metaTags
     * @param array $extra
     */
    public function __construct($title, array $metaTags, array $extra)
    {
        $this->title = $title;
        $this->metaTags = $metaTags;
        $this->extra = $extra;
        $this->compiledAt = (new \DateTime())->format(\DateTime::ISO8601);
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return CompiledMetaTag[]
     */
    public function getMetaTags()
    {
        return $this->metaTags;
    }

    /**
     * @param $name
     * @return array
     */
    public function getExtraValue($name)
    {
        return isset($this->extra[$name]) ? $this->extra[$name] : null;
    }

    /**
     * @return string
     */
    public function getCompiledAt()
    {
        return $this->compiledAt;
    }

}