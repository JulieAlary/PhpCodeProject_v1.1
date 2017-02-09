<?php

namespace CMS\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Carousel
 *
 * @ORM\Table(name="carousel")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\CarouselRepository")
 */
class Carousel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="CMS\BlogBundle\Entity\Gallery", mappedBy="carousel")
     */
    private $galleries;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Carousel
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galleries = new ArrayCollection();
    }

    /**
     * Add gallery
     *
     * @param \CMS\BlogBundle\Entity\Gallery $gallery
     *
     * @return Carousel
     */
    public function addGallery(Gallery $gallery)
    {
        $this->galleries[] = $gallery;

        $gallery->setCarousel($this);

        return $this;
    }

    /**
     * Remove gallery
     *
     * @param \CMS\BlogBundle\Entity\Gallery $gallery
     */
    public function removeGallery(Gallery $gallery)
    {
        $this->galleries->removeElement($gallery);
    }

    /**
     * Get galleries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGalleries()
    {
        return $this->galleries;
    }
}
