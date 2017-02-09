<?php

namespace CMS\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CoreController extends Controller
{

    /**
     * To display th main index
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // Pour le theme
        $em = $this->getDoctrine()->getManager();

        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        return $this->render(
            'CMSCoreBundle:Core:index.html.twig',
            [
                'custom' => $custom
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function contactAction(Request $request)
    {
        $session = $request->getSession();

        $session->getFlashbag()->add('info', 'La page de contact n\'est pas encore dispo');

        return $this->redirectToRoute('cms_core_home');
    }
}