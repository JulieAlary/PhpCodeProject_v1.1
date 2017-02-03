<?php

namespace CMS\BlogBundle\Controller;


use CMS\BlogBundle\Form\UserRoleEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CMS\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteUserAction(User $user, Request $request)
    {
        if (!$user) {
            throw new NotFoundHttpException("l'user n'existe pas");
        }

        $userManager = $this->get('fos_user.user_manager');

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $userManager->deleteUser($user);
            $request->getSession()->getFlashBag()->add('notice', 'User supprimé avec succès.');

            if ($user->hasRole('ROLE_ADMIN') || $user->hasRole('SUPER_ADMIN')) {
                return $this->redirectToRoute('cms_user_list');
            } else {
                return $this->redirectToRoute('cms_blog_home');
            }

        }

        return $this->render(
            'CMSBlogBundle:User:delete.html.twig',
            [
                'user' => $user,
                'form' => $form->createView()
            ]
        );

    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateUserRoleAction(User $user, Request $request)
    {

        $userManager = $this->get('fos_user.user_manager');

        $userManager->updateUser($user);

        $form = $this->get('form.factory')->create(UserRoleEditType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $userManager->updateUser($user);
            $request->getSession()->getFlashBag()->add('notice', 'User bien modifé.');


            return $this->redirectToRoute(
                'cms_user_fiche',
                [
                    'id' => $user->getId(),
                ]
            );
        }

        return $this->render(
            'CMSBlogBundle:User:edit.html.twig',
            [
                'user' => $user,
                'form' => $form->createView()
            ]
        );
    }

}