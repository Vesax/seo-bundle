<?php

namespace Vesax\SEOBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ExtraDataType
 *
 * @package Vesax\SEOBundle\Form\Type
 * @author Artur Vesker
 */
class ExtraDataType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Название поля'])
            ->add('value')
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', 'Vesax\SEOBundle\Model\ExtraData');
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'extra_data';
    }

}