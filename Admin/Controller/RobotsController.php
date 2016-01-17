<?php

namespace Vesax\SEOBundle\Admin\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RobotsController
 *
 * @package Vesax\SEOBundle\Admin\Controller
 * @author Artur Vesker
 *
 * @Route("/robots")
 */
class RobotsController extends Controller
{

    /**
     * @Route("/edit", name="vesax.seo.admin.robots.edit")
     * @Template("VesaxSEOBundle:Admin/Robots:edit.html.twig")
     */
    public function editAction(Request $request)
    {
        $robotsPath = $this->getParameter('kernel.root_dir') . '/../web/robots.txt';

        $content = null;

        if (is_readable($robotsPath)) {
            $content = file_get_contents($robotsPath);
        }

        $form = $this->createFormBuilder(null, ['method' => 'POST']);
        $form = $form->add('content', 'textarea', ['data' => $content, 'attr' => ['rows' => 50]])->getForm();

        if ($form->handleRequest($request)->isValid()) {
            file_put_contents($robotsPath, $form->getData()['content']);
            return $this->redirectToRoute('vesax.seo.admin.robots.edit');
        }

        return [
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'base_template' => $this->container->getParameter('sonata.admin.configuration.templates')['layout'],
            'edit_template' => $this->container->getParameter('sonata.admin.configuration.templates')['edit'],
            'form' => $form->createView()
        ];
    }

}