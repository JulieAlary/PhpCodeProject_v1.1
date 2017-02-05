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
    public function indexAction() {

        return $this->render(
          'CMSBlogBundle:Contact:index.html.twig'
        );
    }

    public function fontAwesomeAction(Request $request) {

        $contact_fa = new Contact();

        $form = $this->get('form.factory')->create(ContactType::class, $contact_fa);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
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
}





