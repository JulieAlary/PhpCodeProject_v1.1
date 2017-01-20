<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        return $this->render('CMSBlogBundle:Article:index.html.twig');

    }

    /**
     * @param $id
     * @return Response
     */
    public function ficheAction($id)
    {
        return $this->render(
            "CMSBlogBundle:Article:fiche.html.twig",
            [
                'id' => $id
            ]
        );

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('info', 'Annonce bien enregistréed');

            return $this->redirectToRoute(
                'cms_blog_fiche',
                [
                    'id' => 5
                ]
            );
        }

        return $this->render('CMSBlogBundle:Article:add.html.twig');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction($id, Request $request)
    {

        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashbag()->add('notice', 'Annonce bien modifiée');

            return $this->redirectToRoute(
                'cms_blog_edit',
                [
                    'id' => 5
                ]
            );

        }

        return $this->render(
            'CMSBlogBundle:Article:edit.html.twig'
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
}