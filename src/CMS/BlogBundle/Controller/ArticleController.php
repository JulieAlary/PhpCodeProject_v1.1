<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Form\ArticleEditType;
use CMS\BlogBundle\Form\ArticleType;
use CMS\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use CMS\BlogBundle\Entity\Article;
use CMS\BlogBundle\Entity\Comment;

use CMS\BlogBundle\Event\PlatformEvents;

// grisés mais utilisés en annotations //
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CMS\BlogBundle\Event\MessagePostEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


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
     * Display View by article with theirs comments
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ficheAction($id, Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // Pour récup l'article par son ID
        $article = $em->getRepository('CMSBlogBundle:Article')->find($id);


        // Récuperation de l'id du menu publié
        $listM = $em->getRepository('CMSBlogBundle:Menu')->findBy(
            array('published' => true),
            array()
        );

//        $idMenu = $listM[0]->getId();

//        // Pour Redirection de article vers liste des article / catégories
//        $listArticles = $listM[0]->getCategories()->getValues();
//        $ArticleBycateId = $listArticles[0]->getId();
//        dump($listArticles);

        // Récupération des commentaires par article
        $comments = $em->getRepository('CMSBlogBundle:Comment')
            ->getCommentForArticle($article->getId());


        if ($article === null) {
            throw new NotFoundHttpException("L'article d'id " . $id . "n'existe pas.");
        }

        // Création du formulaire de commentaire
        $form = $this->createForm(CommentType::class);

        // Vérification des données du formulaire
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $comment = $form->getData();
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $comment->setPublishedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute(
                'cms_blog_fiche',
                [
                    'id' => $article->getId()
                ]
            );
        }

        return $this->render(
            "CMSBlogBundle:Article:fiche.html.twig",
            [
                'article' => $article,
//                'idMenu' => $idMenu,
                'form' => $form->createView(),
                'comment' => $comments,
//                'ArticleBycateId' => $ArticleBycateId
                'custom' => $custom

            ]
        );
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Security("has_role('ROLE_AUTEUR')")
     */
    public function addAction(Request $request)
    {
        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // Création d'une nouvelle entité article
        $article = new Article();

        // Attribution de l'user courant
        $article->setAuthor($this->getUser());

        $form = $this->get('form.factory')->create(ArticleType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

//            //ajout de l'évenement
//            $event = new MessagePostEvent($article->getContent(), $article->getUser());
//
//            // déclenchage de l'événement
//            $this->get('event_dispatcher')->dispatch(PlatformEvents::POST_MESSAGE, $event);
//
//            // on récup ce qui a ét modifié par le lou les listeners
//            $article->setContent($event->getMessage());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();


            $request->getSession()->getFlashBag()->add('info', 'Article bien enregistré.');

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
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );

    }


    /**
     * @param $id
     * @param Request $request
     * @return Response
     *
     * @Security("has_role('ROLE_AUTEUR')")
     */
    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // o recup l'annonce en question
        $article = $em->getRepository('CMSBlogBundle:Article')->find($id);

        if ($article === null) {
            throw new NotFoundHttpException("L'article d'id " . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(ArticleEditType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Article bien modifié.');

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
                'article' => $article,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }

    /**
     * @param $id
     * @return Response
     *
     * @Security("has_role('ROLE_AUTEUR')")
     */
    public function deleteAction($id, Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // On récupérère l'article par son id
        $article = $em->getRepository('CMSBlogBundle:Article')->find($id);

        if ($article === null) {
            throw new NotFoundHttpException("L'article d'id : " . $id . " n'existe pas .");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimé.");

            return $this->redirectToRoute('cms_article_list');
        }

        return $this->render(
            'CMSBlogBundle:Article:delete.html.twig',
            [
                'article' => $article,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
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
     *
     * @Security("has_role('ROLE_AUTEUR')")
     *
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

    /**
     * Fonction de translation
     *
     * @param $name
     * @return Response
     */
    public function translationAction($name)
    {

        return $this->render(
            'CMSBlogBundle:Article:translation.html.twig',
            [
                'name' => $name
            ]
        );
    }

    /**
     * @ParamConverter("json")
     *
     * @param $json
     * @return Response
     */
    public function ParamConverterAction($json)
    {
        return new Response(print_r($json, true));
    }

    /**
     * List all articles in one datatable one page
     * @return Response
     */
    public function listAction()
    {

        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $listArticles = $em->getRepository('CMSBlogBundle:Article')->myFindAll();

        return $this->render(
            'CMSBlogBundle:Article:list.html.twig',
            [
                'listArticles' => $listArticles,
                'custom' => $custom
            ]
        );
    }


}