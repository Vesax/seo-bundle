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
 * Class RedirectRuleAdmin
 *
 * @author Artur Vesker
 */
class RedirectRuleAdmin extends Admin
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
            ->add('sourceTemplate')
            ->add('destination')
            ->add('code')
            ->add('priority')
            ->add('stopped')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('sourceTemplate')
            ->add('destination')
            ->addIdentifier('code')
            ->addIdentifier('priority')
            ->add('stopped')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sourceTemplate', new UrlPatternType(), ['sonata_help' => $this->getPatternHelp()])
            ->add('destination', 'text', ['required' => false, 'sonata_help' => $this->trans('form_destination_description', [], 'VesaxSEOBundle')])
            ->add('code', 'choice', ['choices' => [
                '302' => '302 Found',
                '301' => '301 Moved Permanently',
                '201' => '201 Created',
                '303' => '303 See Other',
                '307' => '307 Temporary Redirect',
                '308' => '308 Permanent Redirect'
            ]])
            ->add('stopped', null, ['required' => false])
            ->add('priority', 'text', [
                'sonata_help' => $this->trans('form_priority_description', [], 'VesaxSEOBundle')
            ])
        ;
    }

    /**
     * @return string
     *
     * TODO: get description from syntax handlers
     */
    private function getPatternHelp()
    {
        return $this->trans('form_pattern_description', [], 'VesaxSEOBundle');
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

    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);

        if (in_array($action, array('tree', 'show', 'edit', 'delete', 'list', 'batch'))
            && $this->hasAccess('create')
            && $this->hasAccess('edit')
            && $this->hasAccess('delete')
            && $this->hasRoute('create')
            && $this->hasRoute('edit')
            && $this->hasRoute('delete')
        ) {
            $list['bulk_upload'] = array(
                'template' => $this->getTemplate('button_bulk_upload'),
            );
        }

        return $list;
    }


}
