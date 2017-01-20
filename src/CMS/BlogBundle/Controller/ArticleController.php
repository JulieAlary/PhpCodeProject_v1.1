<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use CMS\BlogBundle\Entity\Article;
use CMS\BlogBundle\Entity\Image;
use CMS\BlogBundle\Entity\Category;

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

        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        // On lie l'image à l'annonce
        $article->setImage($image);

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

        // retourne toutes les catégories de la base de donnée
        $listCategories = $em->getRepository('CMSBlogBundle:Category')->findAll();

        // On boucle pour les lier à l'annonce
        foreach ($listCategories as $category) {
            $article->addCategory($category);
        }

        $em->flush();

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