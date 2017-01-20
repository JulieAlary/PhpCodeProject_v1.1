<?php

namespace CMS\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CoreController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        return $this->render('CMSCoreBundle:Core:index.html.twig');
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