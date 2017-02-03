<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Category;
use CMS\BlogBundle\Entity\Menu;
use CMS\BlogBundle\Form\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MenuController extends Controller
{

    /**
     * Liste les menus existants
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listMenus = $em->getRepository('CMSBlogBundle:Menu')->findAll();


        return $this->render(
            'CMSBlogBundle:Menu:index.html.twig',
            [
                'listMenus' => $listMenus
            ]
        );
    }

    /**
     * Ajout de menu, choix du nom, des catgéories liées, et de la function isPublished
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addNameAction(Request $request)
    {
        $menu = new Menu();

        $form = $this->get('form.factory')->create(MenuType::class, $menu);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Menu bien enregistrée.');

            return $this->redirectToRoute(
                'cms_menu_index'
            );
        }

        return $this->render(
            'CMSBlogBundle:Menu:add.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteMenuAction($id, Request $request) {

            // Initializing Entity Manager
            $em = $this->getDoctrine()->getManager();

            // On récupérère l'article par son id
            $menu = $em->getRepository('CMSBlogBundle:Menu')->find($id);

            if ($menu === null) {
                throw new NotFoundHttpException("Le menu d'id : " . $id . " n'existe pas .");
            }

            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->remove($menu);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info', "Le menu a bien été supprimé.");

                return $this->redirectToRoute('cms_menu_index');
            }

            return $this->render(
                'CMSBlogBundle:Menu:delete.html.twig',
                [
                    'menu' => $menu,
                    'form' => $form->createView()
                ]
            );
        }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // o recup l'annonce en question
        $menu = $em->getRepository('CMSBlogBundle:Menu')->find($id);

        if ($menu === null) {
            throw new NotFoundHttpException("Le menu d'id " . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(MenuType::class, $menu);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Menu bien modifé.');

            return $this->redirectToRoute(
                'cms_menu_listcate',
                [
                    'id' => $menu->getId()
                ]
            );
        }

        return $this->render(
            'CMSBlogBundle:Menu:edit.html.twig',
            [
                'menu' => $menu,
                'form' => $form->createView()
            ]
        );
    }


    /**
     * Liste les catégories par menu
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listCateByMenuAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('CMSBlogBundle:Menu')->find($id);

        return $this->render(
            "CMSBlogBundle:Menu:list.html.twig",
            [
                'menu' => $menu,
                'id' => $id
            ]
        );

    }

    /**
     * Create the menu user if is published
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isPublishedAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $listM = $em->getRepository('CMSBlogBundle:Menu')->findBy(
            array('published' => true),
            array()
        );
        return $this->render(
            'CMSBlogBundle:Menu:menu.html.twig',
            array('listM' => $listM));

    }


    /**
     * Show the article by menu/category
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showArticleByMenuAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('CMSBlogBundle:Menu')->find($id);

        $repo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('CMSBlogBundle:Article')
        ;

        $listArticles = $repo->findAll();

        $listM = $em->getRepository('CMSBlogBundle:Menu')->findBy(
            array('published' => true),
            array()
        );


        return $this->render(
            'CMSBlogBundle:Menu:show.html.twig',
            [
                'listArticles' => $listArticles,
                'menu' => $menu,
                'id' =>$id,
                'listM' => $listM
            ]
        );
    }
}