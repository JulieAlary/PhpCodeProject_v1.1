<?php

namespace CMS\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parametre
 *
 * @ORM\Table(name="parametre")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\ParametreRepository")
 */
class Parametre
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
     * @ORM\Column(name="blogname", type="string", length=255)
     */
    private $blogname;


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
     * Set blogname
     *
     * @param string $blogname
     *
     * @return Parametre
     */
    public function setBlogname($blogname)
    {
        $this->blogname = $blogname;

        return $this;
    }

    /**
     * Get blogname
     *
     * @return string
     */
    public function getBlogname()
    {
        return $this->blogname;
    }
}

