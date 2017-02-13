<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Category;
use CMS\BlogBundle\Entity\Menu;
use CMS\BlogBundle\Form\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*Utilisé en annotation*/
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MenuController extends Controller
{

    /**
     * Liste les menus existants
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $listMenus = $em->getRepository('CMSBlogBundle:Menu')->findAll();

        return $this->render(
            'CMSBlogBundle:Menu:index.html.twig',
            [
                'listMenus' => $listMenus,
                'custom' => $custom
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

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $form = $this->get('form.factory')->create(MenuType::class, $menu);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Menu bien enregistré.');

            return $this->redirectToRoute(
                'cms_menu_index'
            );
        }

        return $this->render(
            'CMSBlogBundle:Menu:add.html.twig',
            [
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }


    /**
     * Delete the menu action
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteMenuAction($id, Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

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
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

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
                'form' => $form->createView(),
                'custom' => $custom
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

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $menu = $em->getRepository('CMSBlogBundle:Menu')->find($id);

        return $this->render(
            "CMSBlogBundle:Menu:list.html.twig",
            [
                'menu' => $menu,
                'id' => $id,
                'custom' => $custom
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

        // To display name of categories if menu is true
        $listM = $em->getRepository('CMSBlogBundle:Menu')->findBy(
            array('published' => true),
            array()
        );

        // To display contact page awesome if true is coched
        $pageContact = $em->getRepository('CMSBlogBundle:Contact')->findBy(
            array('published' => true),
            array()
        );

        return $this->render(
            'CMSBlogBundle:Menu:menu.html.twig',
            array(
                'listM' => $listM,
                'pageContact' => $pageContact
            ));

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

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $menu = $em->getRepository('CMSBlogBundle:Menu')->find($id);

        $listArticles = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('CMSBlogBundle:Article')
            ->findBy(array(), array('date' => 'desc'));

        dump($listArticles);

        $listM = $em->getRepository('CMSBlogBundle:Menu')->findBy(
            array('published' => true),
            array()
        );

        $idMenu = $listM[0]->getId();
//        dump($idMenu);

        $list = $em->getRepository('CMSBlogBundle:Article')->getArticlesLessPage();
//dump($list);

        return $this->render(
            'CMSBlogBundle:Menu:show.html.twig',
            [
                'listArticles' => $listArticles,
                'menu' => $menu,
                'id' => $id,
                'listM' => $listM,
                'list' => $list,
                'idMenu' => $idMenu,
                'custom' => $custom
            ]
        );
    }
}