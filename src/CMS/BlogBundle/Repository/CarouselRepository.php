<?php

namespace CMS\BlogBundle\Repository;

/**
 * CarouselRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CarouselRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * To get the gallery to an carousel
     *
     * @return array
     */
    public function getCarouselWithGallery()
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->leftJoin('c.galleries', 'gallery')
            ->addSelect('gallery');

        return $qb
            ->getQuery()
            ->getResult();
    }
}
