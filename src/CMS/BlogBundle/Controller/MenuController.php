<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Category;
use CMS\BlogBundle\Entity\Menu;
use CMS\BlogBundle\Form\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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