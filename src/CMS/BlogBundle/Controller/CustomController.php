<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Custom;
use CMS\BlogBundle\Form\CustomThemeType;
use CMS\BlogBundle\Form\CustomType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*Utilisé en annotation*/
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CustomController extends Controller
{

    /**
     * To Display the main page custom
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // o recup l'annonce en question
        $theme = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        return $this->render(
            'CMSBlogBundle:Custom:index.html.twig',
            [
                'theme' => $theme,
                'custom' => $custom
            ]
        );
    }

    /**
     * To add A blog name
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addCustomAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // Création d'une nouvelle entité article
        $blogName = new Custom();

        // Attribution de l'user courant
        $blogName->setAuthor($this->getUser());

        $form = $this->get('form.factory')->create(CustomType::class, $blogName);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($blogName);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Nom du blog bien enregistré.');

            return $this->redirectToRoute(
                'cms_custom_index'
            );
        }

        return $this->render(
            'CMSBlogBundle:Custom:add.html.twig',
            [
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }


    /**
     * To show the name and the description in header
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBlogNameAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // To display contact page awesome if true is coched
        $blogName = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        return $this->render(
            'CMSBlogBundle:Custom:headerCustom.html.twig',
            [
                'blogName' => $blogName
            ]
        );
    }


    /**
     * To Edit the blognames
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editBlogNamesAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // on recup la page créee en question
        $blogNames = $em->getRepository('CMSBlogBundle:Custom')->find($id);

        if ($blogNames === null) {
            throw new NotFoundHttpException("Le custom d'id " . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(CustomType::class, $blogNames);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Custom bien modifié.');

            return $this->redirectToRoute(
                'cms_custom_index',
                [
                    'id' => $id
                ]
            );
        }

        return $this->render(
            'CMSBlogBundle:Custom:edit.html.twig',
            [
                'blogNames' => $blogNames,
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

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // On récupérère l'article par son id
        $blogNames = $em->getRepository('CMSBlogBundle:Custom')->find($id);

        if ($blogNames === null) {
            throw new NotFoundHttpException("Les custom choisis : " . $id . " n'existent pas .");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($blogNames);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Les customs ont bien été supprimés.");

            return $this->redirectToRoute('cms_custom_index');
        }

        return $this->render(
            'CMSBlogBundle:Custom:delete.html.twig',
            [
                'blogNames' => $blogNames,
                'form' => $form->createView(),
                'custom' => $custom

            ]
        );
    }

}