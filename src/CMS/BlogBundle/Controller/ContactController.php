<?php

namespace CMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{

    public function indexAction() {

        return $this->render(
          'CMSBlogBundle:Contact:index.html.twig'
        );
    }
}