<?php

namespace CMS\BlogBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntifloodValidator extends ConstraintValidator
{

    private $requestStack;
    private $em;

    /**
     * AntifloodValidator constructor.
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $em
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    /**
     * A mettre en place une fois que l'ip sera stocké en BDD
     *
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
//        // pour récupérer l'objet
//        $request = $this->requestStack->getCurrentRequest();
//
//        // on récup l'ip de celui qui poste
//        $ip = $request->getClientIp();
//
//        // On vérifie si cette IP a déjà posté uen candidature il y a moins de 15secondes
//        // article pourra etre remplacé par commentaire
//        $isFlood = $this->em
//            ->getRepository('CMSBlogBundle:Article')
//            ->isFlood($ip, 15);
//
//        if ($isFlood) {
//            // cette ligne qui déclenche l'erreur pour le formulaire, avec en argument le message
//            $this->context->addViolation($constraint->message);
//        }

        if (strlen($value) < 3) {

            $this->context->addViolation($constraint->message);
        }
    }
}