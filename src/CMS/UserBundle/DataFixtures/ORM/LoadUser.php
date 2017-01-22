<?php

namespace CMS\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CMS\UserBundle\Entity\User;

class LoadUser implements FixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        // les noms d'utils à créer
        $listNames = array('Util-1', 'Util-2', "Util-3");

        // Pour chaque nom on crée l'util
        foreach ($listNames as $name) {

            $user = new User;

            // Pour l'instant mot de passe et nom identiques
            $user->setUsername($name);
            $user->setPassword($name);

            // le sel à vide pour l'instant
            $user->setSalt('');

            // Définition du reole a user pour l'isntant
            $user->setRoles(array('ROLE_SUPER_ADMIN'));

            // on persiste
            $manager->persist($user);
        }

        // On enregistre
        $manager->flush();
    }
}