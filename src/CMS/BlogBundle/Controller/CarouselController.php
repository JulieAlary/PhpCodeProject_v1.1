<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Carousel;
use CMS\BlogBundle\Entity\Gallery;
use CMS\BlogBundle\Form\CarouselType;
use CMS\BlogBundle\Form\GalleryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CarouselController extends Controller
{

    /**
     * Display the index page of carousel
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render(
            'CMSBlogBundle:Custom/Carousel:index.html.twig'
        );
    }

    /**
     * Add Carousel name
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

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
            ]
        );
    }

    public function addGalleryAction(Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

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
                'form' => $form->createView()
            ]
        );
    }

}