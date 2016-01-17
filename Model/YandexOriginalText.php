<?php

namespace Vesax\SEOBundle\Model;

use JMS\Serializer\Annotation as Serialized;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class OriginalText.
 *
 * @author Artur Vesker
 *
 * @Serialized\XmlRoot("original-text")
 */
class YandexOriginalText
{
    /**
     * @var int
     *
     * @Serialized\Type("string")
     */
    protected $id;

    /**
     * @var Link
     *
     * @Serialized\Type("Vesax\SEOBundle\Model\Link")
     */
    protected $link;

    /**
     * @var string
     *
     * @Serialized\Type("string")
     * @Serialized\XmlElement(cdata=false)
     * @Assert\Length(min="500", max="32000")
     */
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
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
    public function __toString()
    {
        return $this->content;
    }
}
