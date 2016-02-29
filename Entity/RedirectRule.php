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
     */
    protected $stopped;

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
     * @return self
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
     * @return self
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
     * @return self
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
     * @return self
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
        // TODO: Implement isStopped() method.
    }
}