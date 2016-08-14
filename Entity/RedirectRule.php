<?php

namespace Vesax\SEOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vesax\SEOBundle\RedirectRule\RedirectRuleInterface;

/**
 * Class RedirectRule
 *
 * @package Vesax\SEOBundle\Entity
 * @author Artur Vesker
 *
 * @ORM\Entity(repositoryClass="Vesax\SEOBundle\RedirectRule\DoctrineRedirectRuleRepository")
 * @ORM\Table(name="seo_redirect_rules")
 */
class RedirectRule implements RedirectRuleInterface
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
    protected $sourceTemplate;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $destination;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $code;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $priority = 0;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $stopped = false;

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
    public function getSourceTemplate()
    {
        return $this->sourceTemplate;
    }

    /**
     * @param string $sourceTemplate
     * @return $this
     */
    public function setSourceTemplate($sourceTemplate)
    {
        $this->sourceTemplate = $sourceTemplate;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isStopped()
    {
        return $this->stopped;
    }

    /**
     * @param boolean $stopped
     * @return $this
     */
    public function setStopped($stopped)
    {
        $this->stopped = $stopped;

        return $this;
    }
}