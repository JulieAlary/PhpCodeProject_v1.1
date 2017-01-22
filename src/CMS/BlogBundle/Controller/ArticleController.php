<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use CMS\BlogBundle\Entity\Article;


class ArticleController extends Controller
{
    /**
     * @param $page
     * @return Response
     */
    public function indexAction($page)
    {

        if ($page < 1) {
            throw new NotFoundHttpException('Page "' . $page . '" inexistante.');
        }

        $nbPerPage = 3;

        // Récupération de la liste de tous le sarticles
        $listArticles = $this->getDoctrine()
            ->getManager()
            ->getRepository('CMSBlogBundle:Article')
            ->getArticles($page, $nbPerPage);

        $nbPages = ceil(count($listArticles) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . "n'existe pas.");
        }

        return $this->render(
            'CMSBlogBundle:Article:index.html.twig',
            [
                'listArticles' => $listArticles,
                'nbPages' => $nbPages,
                'page' => $page,
            ]
        );

    }

    /**
     * @param $id
     * @return Response
     */
    public function ficheAction($id)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour récup l'article par son ID
        $article = $em->getRepository('CMSBlogBundle:Article')->find($id);

        if ($article === null) {
            throw new NotFoundHttpException("L'article d'id " . $id . "n'existe pas.");
        }

        return $this->render(
            "CMSBlogBundle:Article:fiche.html.twig",
            [
                'article' => $article
            ]
        );

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashbag()->add('notice', 'Article bien enregistré.');

            return $this->redirectToRoute(
                'cms_blog_fiche',
                [
                    'id' => $article->getId()
                ]
            );
        }

        return $this->render('CMSBlogBundle:Article:add.html.twig');

    }


    /**
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // o recup l'annonce en question
        $article = $em->getRepository('CMSBlogBundle:Article')->find($id);

        if ($article === null) {
            throw new NotFoundHttpException("L'article d'id " . $id . " n'existe pas.");
        }

        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Article bien modifé.');

            return $this->redirectToRoute(
                'cms_blog_fiche',
                [
                    'id' => $article->getId()
                ]
            );
        }

        return $this->render(
            'CMSBlogBundle:Article:edit.html.twig',
            [
                'article' => $article
            ]
        );
    }

    /**
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // On récupérère l'article par son id
        $article = $em->getRepository('CMSBlogBundle:Article')->find($id);

        if ($article === null) {
            throw new NotFoundHttpException("L'article d'id : " . $id . " n'existe pas .");
        }

        // On blouccle sur les catégories pour les supprimer
        foreach ($article->getCategories() as $category) {
            $article->removeCategory($category);
        }

        $em->flush();

        return $this->render('CMSBlogBundle:Article:delete.html.twig');
    }

    /**
     * @param $limit
     * @return Response
     */
    public function menuAction($limit)
    {

        $em = $this->getDoctrine()->getManager();

        $listArticles = $em->getRepository('CMSBlogBundle:Article')->findBy(
            array(),
            array('date' => 'desc'),
            $limit,
            0
        );

        return $this->render(
            'CMSBlogBundle:Article:menu.html.twig',
            [
                'listArticles' => $listArticles
            ]
        );
    }

    /**
     * Exemple à implémenter pour pouboir modifier les images existantes
     *
     * @param $articleId
     * @return Response
     */
    public function editImageAction($articleId)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce
        $article = $em->getRepository('CMSBlogBundle:Article')->find($articleId);

        // On modifie l'URL de l'image par exemple
        $article->getImage()->setUrl('test.png');

        // On n'a pas besoin de persister l'annonce ni l'image.
        // Rappelez-vous, ces entités sont automatiquement persistées car
        // on les a récupérées depuis Doctrine lui-même

        // On déclenche la modification
        $em->flush();

        return new Response('OK');
    }


}