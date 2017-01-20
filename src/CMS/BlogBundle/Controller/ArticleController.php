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

        // Notre liste d'annonce en dur
        $listArticles = array(
            array(
                'title' => 'Recherche développpeur Symfony',
                'id' => 1,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Mission de webmaster',
                'id' => 2,
                'author' => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Offre de stage webdesigner',
                'id' => 3,
                'author' => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date' => new \Datetime())
        );


        return $this->render(
            'CMSBlogBundle:Article:index.html.twig',
            [
                'listArticles' => $listArticles
            ]
        );

    }

    /**
     * @param $id
     * @return Response
     */
    public function ficheAction($id)
    {

        // Récup le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CMSBlogBundle:Article');

        // Récup l'entit éntité correspondant à l'id
        $article = $repository->find($id);

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

        // Création de l'entité
        $article = new Article();
        $article->setTitle('Recherche développeur Symfony.');
        $article->setAuthor('Alexandre');
        $article->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('info', 'Annonce bien enregistréed');

            return $this->redirectToRoute(
                'cms_blog_fiche',
                [
                    'id' => $article->getId()
                ]
            );
        }

        return $this->render(
            'CMSBlogBundle:Article:add.html.twig',
            [
                'article' => $article
            ]
        );
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction($id, Request $request)
    {

        $article = array(
            'title' => 'Recherche développpeur Symfony',
            'id' => $id,
            'author' => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date' => new \Datetime()
        );


        return $this->render(
            'CMSBlogBundle:Article:edit.html.twig',
            [
                'article' => $article
            ]
        );
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteAction($id)
    {

        return $this->render('CMSBlogBundle:Article:delete.html.twig');
    }

    /**
     * @param $limit
     * @return Response
     */
    public function menuAction($limit)
    {

        $listArticles = array(
            array('id' => 2, 'title' => 'Histoire de Symfony'),
            array('id' => 5, 'title' => 'Controller'),
            array('id' => 9, 'title' => 'Doctrine')
        );

        return $this->render(
            'CMSBlogBundle:Article:menu.html.twig',
            [
                'listArticles' => $listArticles
            ]
        );
    }


}