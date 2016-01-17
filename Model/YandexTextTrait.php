<?php

namespace Vesax\SEOBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class YandexTextTrait.
 *
 * @author Artur Vesker
 */
trait YandexTextTrait
{
    /**
     * @var Link
     *
     * @ORM\Column(type="json")
     */
    protected $yandexTextlink;

    abstract public function getYandexText();

    /**
     * @return Link
     */
    public function getYandexTextlink()
    {
        return $this->yandexTextlink;
    }

    /**
     * @param Link $yandexTextlink
     *
     * @return self
     */
    public function setYandexTextlink($yandexTextlink)
    {
        $this->yandexTextlink = $yandexTextlink;

        return $this;
    }
}
