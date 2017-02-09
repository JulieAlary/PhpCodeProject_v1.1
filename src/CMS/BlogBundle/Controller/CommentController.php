<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * L'affichage et l'ajout de comment a été intégré avec le controller
 * Article, TODO tout basculer ici....
 *
 * Class CommentController
 * @package CMS\BlogBundle\Controller
 */
class CommentController extends Controller {

    /**
     * Supprime le commentaire et renvoie vers la bonne route
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id, Request $request) {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // On récupérère le commentaire par son id
        $comment = $em->getRepository('CMSBlogBundle:Comment')->find($id);

        if ($comment === null) {
            throw new NotFoundHttpException("Le commentaire d'id : " . $id . " n'existe pas .");
        }

        // Permet de passer l'id de l'article concerné pour le redirectToRoute
        $article = $comment->getArticle()->getId();


        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été supprimé.");

            return $this->redirectToRoute('cms_blog_fiche', array('id'=> $article));
        }

        return $this->render(
            'CMSBlogBundle:Comment:delete.html.twig',
            [
                'comment' => $comment,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }
}