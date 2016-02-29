<?php

namespace Vesax\SEOBundle\Admin;

use Doctrine\Common\Cache\ClearableCache;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\CallbackTransformer;
use Vesax\SEOBundle\Form\Type\ExtraDataType;
use Vesax\SEOBundle\Form\Type\MetaTagType;
use Vesax\SEOBundle\Form\Type\UrlPatternType;

/**
 * Class RuleAdmin.
 *
 * @author Artur Vesker
 */
class RuleAdmin extends Admin
{

    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'priority',
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('pattern')
            ->add('title')
            ->add('priority')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('pattern')
            ->addIdentifier('title')
            ->addIdentifier('priority')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('General')
                ->with('Основные настройки правила')
                    ->add('pattern', new UrlPatternType(), ['sonata_help' => $this->getPatternHelp()])
                    ->add('title', 'text', ['required' => false, 'sonata_help' => 'Заголовок сайта, отображается в тегах &lt;title&gt;&lt;/title&gt;'])
                    ->add('priority', 'text', ['sonata_help' => 'Приоритет правила. Если url соответстует нескольким правилам, то применяется правило с наибольшим приоритетом'])
                ->end()
            ->end()
            ->tab('Meta-Tags')
                ->with('Мета теги', ['description' => 'Для тегов должен быть указан name или(и) property. В content разрешно использование переменных. Список доступных переменных и условий отличается для страниц - необходимо уточнять у разработчиков.'])
                    ->add('meta_tags', 'sonata_type_native_collection', [
                        'allow_add' => true,
                        'allow_delete' => true,
                        'type' => new MetaTagType(),
                        'required' => false,
                        'label' => false,
                        'prototype_name' => 'meta_tag',
                        'by_reference' => false
                    ])
                ->end()
            ->end()
            ->tab('Extra')
                ->with('Дополнительные данные', ['description' => 'Любые дополнительные данные. Например - заголовки. Использование данных их этого списка должно быть реализовано разработчиками. В значениях разрешно использование переменных. Список доступных переменных и условий отличается для страниц - необходимо уточнять у разработчиков.'])
                    ->add('extra', 'sonata_type_native_collection', [
                        'allow_add' => true,
                        'allow_delete' => true,
                        'type' => new ExtraDataType(),
                        'required' => false,
                        'label' => false,
                        'prototype_name' => 'extra_field',
                        'by_reference' => false
                    ])
                ->end()
            ->end()
        ;
    }

    /**
     * @return string
     *
     * TODO: get description from syntax handlers
     */
    private function getPatternHelp()
    {
        return "Шаблон url, для которого будет выполняться это правило. Новые правила приоритетнее старых.<br>Поддерживаемые маркеры:<ul><li>{*} - любая последовательность любой длины. Пример: /news/{*}</li></ul>
        Добавление/обновление/удаление правила вызовет очистку кеша. Для сохранения производительности сайта рекомендуется обновлять правило пакетно.";
    }

    /**
     * @param mixed $object
     * @return mixed|void
     */
    public function postUpdate($object)
    {
        $this->clearCache();
    }

    /**
     * @param mixed $object
     * @return mixed|void
     */
    public function postPersist($object)
    {
        $this->clearCache();
    }

    /**
     * @param mixed $object
     * @return mixed|void
     */
    public function postRemove($object)
    {
        $this->clearCache();
    }

    /**
     * Clear metadata cache
     */
    private function clearCache()
    {
        $container = $this->getConfigurationPool()->getContainer();

        if ($container->has('vesax.seo.metadata_cache')) {
            $cache = $container->get('vesax.seo.metadata_cache');

            if ($cache instanceof ClearableCache) {
                $cache->deleteAll();
            }
        }
    }


}
