<?php

namespace CMS\UserBundle\Controller;

use CMS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller {

    public function editAction(Request $request) {

        $user = new User();

        $form = $this->createForm(ProfileFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $user->getAvatar();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('avatar_directory'),
                $fileName
            );

            $user->setAvatar($fileName);

            // ... persist the $product variable or any other work

            return $this->redirect($this->generateUrl('fos_user_profile_show'));

        }

        return $this->render('CMSUserBundle:Profile:show_content.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}