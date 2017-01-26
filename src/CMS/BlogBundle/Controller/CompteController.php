<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompteController extends Controller {

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id, Request $request) {

        $userManager = $this->get('fos_user.user_manager');

        $users = $userManager->findUserBy(['id' => $id]);

        return $this->render(
            'CMSBlogBundle:Compte:index.html.twig',
            [
                'id' =>$id,
                'users' => $users
            ]

        );
    }
}