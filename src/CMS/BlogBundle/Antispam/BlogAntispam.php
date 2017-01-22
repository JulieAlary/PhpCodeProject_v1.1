<?php

namespace CMS\BlogBundle\Antispam;

class BlogAntispam
{
    private $mailer;
    private $locale;
    private $minLength;

    /**
     * BlogAntispam constructor.
     * @param \Swift_Mailer $mailer
     * @param $locale
     * @param $minLength
     */
    public function __construct(\Swift_Mailer $mailer, $minLength)
    {
        $this->mailer = $mailer;
        $this->minLength = (int) $minLength;
    }

    /**
     * @param $locale
     */
    public function setLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * Vérifie si le texte est un psam ou pas
     *
     * @param $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text) < 50;
    }
}