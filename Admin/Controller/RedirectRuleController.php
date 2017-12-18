<?php

namespace Vesax\SEOBundle\Admin\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Vesax\SEOBundle\RedirectRule\BulkUploadHandler;

/**
 * Class RedirectRuleController
 *
 * @package Vesax\SEOBundle\Admin\Controller
 * @author Artur Vesker
 *
 * @Route("/redirectrule")
 */
class RedirectRuleController extends Controller
{

    /**
     * @Route("/upload", name="vesax.seo.admin.redirectrule.upload")
     * @Template("VesaxSEOBundle:Admin/RedirectRule:upload.html.twig")
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function uploadAction(Request $request)
    {

        $form = $this->createFormBuilder(null, ['method' => 'POST']);
        $form = $form->add('content', FileType::class, ['required' => true])->getForm();

        if ($form->handleRequest($request)->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('content')->getData();
            try {
                $this->getBulkHandler()->handleCSVFile($file);

                $this->addFlash('success', sprintf('Redirect rules have been updated successfully'));
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', $e->getMessage());
            }

            return $this->redirectToRoute('vesax.seo.admin.redirectrule.upload');
        }

        return [
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'base_template' => $this->container->getParameter('sonata.admin.configuration.templates')['layout'],
            'edit_template' => $this->container->getParameter('sonata.admin.configuration.templates')['edit'],
            'form' => $form->createView()
        ];
    }

    /**
     * @return BulkUploadHandler
     */
    private function getBulkHandler()
    {
        return $this->get('vesax.seo.redirect_rule.bulk_handler');
    }

}