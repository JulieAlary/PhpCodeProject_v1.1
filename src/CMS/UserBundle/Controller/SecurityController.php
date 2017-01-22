<?php

namespace CMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        // Si l'util est déjà identifé on le redirige vers l'acceuil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('cms_blog_home');
        }

        // Permet de récup l'erruer et le nom d'util si le jamais le formualire mdp était mal rempli
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render(
            'CMSUserBundle:Security:login.html.twig',
            [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error' => $authenticationUtils->getLastAuthenticationError(),
            ]
        );

    }

}