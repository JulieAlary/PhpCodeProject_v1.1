<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Category;
use CMS\BlogBundle\Entity\Menu;
use CMS\BlogBundle\Form\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller
{

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

    public function addNameAction(Request $request, Category $category)
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
                'category' => $category,
                'form' => $form->createView()
            ]
        );
    }
}