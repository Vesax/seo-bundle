<?php

namespace Vesax\SEOBundle\Model;

use Vesax\SEOBundle\Metadata\MetaTagInterface;

/**
 * Class MetaTag
 *
 * @package Vesax\SEOBundle\Model
 * @author Artur Vesker
 */
class MetaTag implements MetaTagInterface
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $property;

    /**
     * @var string
     */
    protected $content;

    public function __construct($name = null, $property = null, $content = null)
    {
        $this->name = $name;
        $this->property = $property;
        $this->content = $content;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param null|string $property
     * @return self
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @param string $content
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

}