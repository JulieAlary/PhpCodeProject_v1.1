<?php

namespace CMS\BlogBundle\Controller;

use CMS\BlogBundle\Entity\Contact;
use CMS\BlogBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*Utilisé en annotation*/
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ContactController extends Controller
{

    /**
     * To display the main contact page admin
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

        // To display contact page awesome if true is published
        $pageContact = $em->getRepository('CMSBlogBundle:Contact')->findBy(
            array('published' => true),
            array()
        );

        // To display contact page awesome if true is published
        $pageContactFalse = $em->getRepository('CMSBlogBundle:Contact')->findBy(
            array('published' => false),
            array()
        );

        return $this->render(
            'CMSBlogBundle:Contact:index.html.twig',
            [
                'pageContact' => $pageContact,
                'pageContactFalse' => $pageContactFalse,
                'custom' => $custom
            ]
        );
    }

    /**
     * To edit FontAwesome Contact Page
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editContactFaAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // on recup la page créee en question
        $contactPage = $em->getRepository('CMSBlogBundle:Contact')->find($id);

        if ($contactPage === null) {
            throw new NotFoundHttpException("La page de contact d'id " . $id . " n'existe pas.");
        }

        $form = $this->get('form.factory')->create(ContactType::class, $contactPage);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Page de contact bien modifée.');

            return $this->redirectToRoute(
                'cms_contact_index',
                [
                    'id' => $id
                ]
            );
        }

        return $this->render(
            'CMSBlogBundle:Contact:editPageFA.html.twig',
            [
                'contactPage' => $contactPage,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }

    /**
     * To delete FontAwesome ContactPage
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteContactFaAction($id, Request $request)
    {

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        // On récupérère la page contact par son id
        $pageContact = $em->getRepository('CMSBlogBundle:Contact')->find($id);

        if ($pageContact === null) {
            throw new NotFoundHttpException("La page de contact : " . $id . " n'existe pas .");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($pageContact);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "La page de contact a bien été supprimé.");

            return $this->redirectToRoute('cms_contact_index');
        }

        return $this->render(
            'CMSBlogBundle:Contact:deleteFa.html.twig',
            [
                'pageContact' => $pageContact,
                'form' => $form->createView(),
                'custom' => $custom
            ]
        );
    }

    /**
     * To create a FontAwesome Contact Page
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function fontAwesomeAction(Request $request)
    {

        $contact_fa = new Contact();

        // Initializing Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Pour le theme
        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();

        $form = $this->get('form.factory')->create(ContactType::class, $contact_fa);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $contact_fa->setAuthor($this->getUser());


            $em = $this->getDoctrine()->getManager();
            $em->persist($contact_fa);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Icône(s) bien enregistrée(s).');

            return $this->redirectToRoute(
                'cms_contact_index'
            );
        }

        return $this->render(
            'CMSBlogBundle:Contact:addFontAwesome.html.twig',
            [
                'form' => $form->createView(),
                'custom' => $custom
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

        $custom = $em->getRepository('CMSBlogBundle:Custom')->findAll();


        // To display contact page awesome if true is published
        $pageContact = $em->getRepository('CMSBlogBundle:Contact')->findBy(
            array('published' => true),
            array()
        );

        // To display contact page awesome if false is published
        $pageContactFalse = $em->getRepository('CMSBlogBundle:Contact')->findBy(
            array('published' => false),
            array()
        );


        return $this->render(
            'CMSBlogBundle:Contact:pageFA.html.twig',
            [
                'pageContact' => $pageContact,
                'pageContactFalse' => $pageContactFalse,
                'custom' => $custom
            ]
        );
    }
}





