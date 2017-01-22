<?php

namespace CMS\BlogBundle\Beta;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;


class BetaListener
{

    // Le processeur
    protected $betaHTML;

    // La date de fin de l'évenmeent :bannière de beta
    protected $enDate;

    /**
     * Date de fin de la version beta!
     *
     * BetaListener constructor.
     * @param BetaHTMLAdder $betaHTML
     * @param $enDate
     */
    public function __construct(BetaHTMLAdder $betaHTML, $enDate)
    {
        $this->betaHTML = $betaHTML;
        $this->enDate = new \DateTime($enDate);
    }

    /**
     *
     */
    public function processBeta(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $remainingDays = $this->enDate->diff(new \Datetime())->days;

        if ($remainingDays <= 0) {
            // Si la date est dépassée, on ne fait rien
            return;
        }

        // On utilise notre BeatHTML
        $response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);

        // on met à jour la réponse avec la nouvelle valeur
        $event->setResponse($response);
    }
}