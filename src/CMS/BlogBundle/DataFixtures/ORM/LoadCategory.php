<?php

namespace CMS\BlogBundle\DataFixtures\ORM;


use CMS\BlogBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadCategory implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // Liste de catégories à ajouter
        $names = array(
            'PHP',
            'Symfony',
            'Doctrine',
            'Bundle',
            'MVC',
            'Console'
        );

        foreach ($names as $name) {
            // On crée une catégorie
            $category = new Category();
            $category->setName($name);

            // On persiste
            $manager->persist($category);
        }

        // On enregistre
        $manager->flush();
    }
}