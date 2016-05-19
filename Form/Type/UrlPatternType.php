<?php

namespace Vesax\SEOBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class UrlPatternType
 *
 * @package Vesax\SEOBundle\Form\Type
 * @author Artur Vesker
 */
class UrlPatternType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {

                $data = $event->getData();

                $normalized = parse_url($data, PHP_URL_PATH);

                if (strpos($normalized, '/app_dev.php') !== false) {
                    $normalized = substr($normalized, 12);
                }

                if ($query = parse_url($data, PHP_URL_QUERY)) {
                    $normalized .= '?' . $query;
                }

                $event->setData($normalized);
            });
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return self::class;
    }


}
