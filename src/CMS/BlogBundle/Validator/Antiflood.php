<?php

namespace CMS\BlogBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class Antiflood
 * @package CMS\BlogBundle\Validator
 * @Annotation
 */
class Antiflood extends Constraint
{

    public $message = "Vous avez déjà posté un message il y a moins de 15 secondes, merci de patienter un peu avant d'en poster un nouveau.";

    /**
     * Fait appel à l'ailias du service
     *
     * @return string
     */
    public function validatedBy()
    {
        return 'cms_blog_antiflood';
    }
}