<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Carousel;
use CMS\BlogBundle\Entity\Gallery;
use CMS\BlogBundle\Form\CarouselType;
use CMS\BlogBundle\Form\GalleryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarouselController extends Controller
{

    /**
     * To display main page with published carousel existant
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $carousel = $em->getRepository('CMSBlogBundle:Carousel')->findAll();

        $gallery = $em
            ->getRepository('CMSBlogBundle:Gallery')
            ->findAll();

        return $this->render(
            'CMSBlogBundle:Custom/Carousel:index.html.twig',
            [
                'carousel' => $carousel,
                'gallery' => $gallery,
                'custom' => $custom
            ]
        );
    }

    /**
     * Add Carousel name and is published
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // Création d'une nouvelle entité article
        $carousel = new Carousel();

        $form = $this->get('form.factory')->create(CarouselType::class, $carousel);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($carousel);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Carousel enregistrée.');

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
     * Add gallery photo to an existant carousel
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addGalleryAction(Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // Création d'une nouvelle entité article
        $gallery = new Gallery();

        $form = $this->get('form.factory')->create(GalleryType::class, $gallery);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($gallery);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Image enregistrée.');

            return $this->redirectToRoute(
                'cms_custom_carousel'
            );
        }

        return $this->render(
            'CMSBlogBundle:Custom/Carousel:add.html.twig',
            [
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );

    }

    /**
     * To edit the selectionned Carousel
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editCarouselAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // o recup l'annonce en question
        $carousel = $em->getRepository('CMSBlogBundle:Carousel')->find($id);

        if ($carousel === null) {
            throw new NotFoundHttpException("Le carousel " . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(CarouselType::class, $carousel);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien modifé.');

            return $this->redirectToRoute(
                'cms_custom_carousel'
            );
        }

        return $this->render(
            'CMSBlogBundle:Custom/Carousel:edit.html.twig',
            [
                'carousel' => $carousel,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }

    public function deleteCarouselAction($id, Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // On récupérère l'article par son id
        $carousel = $em->getRepository('CMSBlogBundle:Carousel')->find($id);

        if ($carousel === null) {
            throw new NotFoundHttpException("Le carousel : " . $id . " n'existe pas .");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($carousel);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le carousel a bien été supprimé.");

            return $this->redirectToRoute('cms_custom_carousel');
        }

        return $this->render(
            'CMSBlogBundle:Custom/Carousel:delete.html.twig',
            [
                'carousel' => $carousel,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }


    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isPublishedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // To display the carousel
        $carousel = $em->getRepository('CMSBlogBundle:Carousel')->findBy(
            array('published' => true),
            array()
        );

        $gallery = $em->getRepository('CMSBlogBundle:Gallery')->findAll();

        return $this->render(
            'CMSBlogBundle:Custom/Carousel:show.html.twig',
            [
                'carousel' => $carousel,
                'gallery' => $gallery
            ]
        );

    }

}