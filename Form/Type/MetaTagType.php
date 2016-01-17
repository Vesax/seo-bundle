<?php

namespace Vesax\SEOBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MetaTagType
 *
 * @package Vesax\SEOBundle\Form\Type
 * @author Artur Vesker
 */
class MetaTagType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['required' => false])
            ->add('content', 'text', ['required' => true])
            ->add('property', 'text', ['required' => false])
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(['data_class' => 'Vesax\SEOBundle\Model\MetaTag']);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'meta_tag';
    }

}