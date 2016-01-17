<?php

namespace Vesax\SEOBundle\Entity;

use Vesax\SEOBundle\Metadata\MetaExtraDataInterface;
use Vesax\SEOBundle\Metadata\MetaTagInterface;
use Vesax\SEOBundle\Rule\RuleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Rule
 *
 * @package Vesax\SEOBundle\Entity
 * @author Artur Vesker
 *
 * @ORM\Entity()
 * @ORM\Table(name="seo_rules")
 */
class Rule implements RuleInterface
{

    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $pattern;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    protected $metaTags = [];

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    protected $extra = [];

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $priority = 0;

    public function __construct($pattern = null, $title = null, $metaTags = [], $extra = [])
    {
        $this->pattern = $pattern;
        $this->title = $title;
        $this->metaTags = $metaTags;
        $this->extra = $extra;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return self
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return MetaTagInterface[]
     */
    public function getMetaTags()
    {
        return $this->metaTags;
    }

    /**
     * @param array $metaTags
     * @return self
     */
    public function setMetaTags($metaTags)
    {
        $this->metaTags = [];

        foreach ($metaTags as $metaTag) {
            $this->metaTags[] = clone $metaTag;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     * @return self
     */
    public function setExtra(array $extra)
    {
        $this->extra = [];

        foreach ($extra as $data) {
            $this->extra[] = clone $data;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return self
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

}