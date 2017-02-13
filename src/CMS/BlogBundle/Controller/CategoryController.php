<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Category;
use CMS\BlogBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*Utilisé en annotation*/
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $listCategories = $em->getRepository('CMSBlogBundle:Category')->findAll();

        return $this->render(
            'CMSBlogBundle:Category:list.html.twig',
            [
                'listCategories' => $listCategories,
                'custom' => $custom

            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {

        $category = new Category();

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $form = $this->get('form.factory')->create(CategoryType::class, $category);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie bien enregistrée.');

            return $this->redirectToRoute(
                'cms_category_list'
            );
        }

        return $this->render(
            'CMSBlogBundle:Category:add.html.twig',
            [
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
    public function deleteAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $category = $em->getRepository('CMSBlogBundle:Category')->find($id);

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "La catégorie a bien été supprimée.");

            return $this->redirectToRoute('cms_category_list');
        }
        return $this->render(
            'CMSBlogBundle:Category:delete.html.twig',
            [
                'category' => $category,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }
}