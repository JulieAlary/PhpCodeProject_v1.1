<?php

namespace CMS\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CMS\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;




class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $users = $userManager->findUsers();

        return $this->render(
            'CMSBlogBundle:User:list.html.twig',
            [
                'users' => $users,
            ]
        );
    }
}