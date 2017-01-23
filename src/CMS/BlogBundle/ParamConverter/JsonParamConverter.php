<?php

namespace CMS\BlogBundle\ParamConverter;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class JsonParamConverter implements ParamConverterInterface
{

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    function supports(ParamConverter $configuration)
    {
        // Si ce n'ets pas du json on applique pas le convertisseur
        if ('json' !== $configuration->getName()) {
            return false;
        }
        return true;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     */
    function apply(Request $request, ParamConverter $configuration)
    {
        // On récup la valeur actuelle de l'attribut
        $json = $request->attributes->get('json');

        // On effectue l'action : le decoder
        $json = json_decode($json, true);

        // On met à jour la nouvelle valeur de l'attribut
        $request->attributes->set('json', $json);
    }
}