<?php

namespace CMS\BlogBundle\Twig;

use CMS\BlogBundle\Antispam\BlogAntispam;

/**
 * Extension de Twig créee pour gérer les spam
 *
 * Class AntispamExtension
 * @package CMS\BlogBundle\Twig
 */
class AntispamExtension extends \Twig_Extension
{

    /**
     * @var BlogAntispam
     */
    private $blogAntispam;

    public function __construct(BlogAntispam $blogAntispam)
    {
        $this->blogAntispam = $blogAntispam;
    }

    /**
     * @param $text
     * @return mixed
     */
    public function checkIfArgumentIsSpam($text)
    {
        return $this->blogAntispam->isSpam($text);
    }

    // Twig va exécuter cette méthode pour savoir quelles fonctions ajoute notre service
    public function getFunctions() {
        return array(
          new \Twig_SimpleFunction('checkIfSpam', array($this, 'checkIfArgumentIsSpam')),
        );
    }

    // La méthode getName() identfiie l'extension de twig, c'ets obligatoiire
    public function getName() {
        return 'BlogAntispam';

    }
}