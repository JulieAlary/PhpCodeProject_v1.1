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

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ficheAction($id, Request $request)
    {

        $userManager = $this->get('fos_user.user_manager');

        $users = $userManager->findUserBy(['id' => $id]);

        return $this->render(
            'CMSBlogBundle:User:fiche.html.twig',
            [
                'id' => $id,
                'users' => $users
            ]
        );
    }

    /**
     * @param User $user
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUserAction(User $user, $id)
    {

        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUserBy(['id' => $id]);

        $users->setEnabled($users);
        $users->flush();

        return $this->redirectToRoute('cms_user_list');
    }

}