<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Contact;
use CMS\BlogBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{

    /**
     * To display the main contact page admin
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // To display contact page awesome if true is published
        $pageContact = $em->getRepository('CMSBlogBundle:Contact')->findBy(
            array('published' => true),
            array()
        );

        return $this->render(
            'CMSBlogBundle:Contact:index.html.twig',
            [
                'pageContact' => $pageContact
            ]
        );
    }

    /**
     * To create a FontAwesome Contact Page
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function fontAwesomeAction(Request $request)
    {

        $contact_fa = new Contact();

        $form = $this->get('form.factory')->create(ContactType::class, $contact_fa);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $contact_fa->setAuthor($this->getUser());


            $em = $this->getDoctrine()->getManager();
            $em->persist($contact_fa);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Icône(s) bien enregistré(e)s.');

            return $this->redirectToRoute(
                'cms_contact_index'
            );
        }

        return $this->render(
            'CMSBlogBundle:Contact:addFontAwesome.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * To display the FontAwesome contact page
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewFontAwesomePageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // To display contact page awesome if true is published
        $pageContact = $em->getRepository('CMSBlogBundle:Contact')->findBy(
            array('published' => true),
            array()
        );

        return $this->render(
            'CMSBlogBundle:Contact:pageFA.html.twig',
            [
                'pageContact' => $pageContact
            ]
        );
    }
}





