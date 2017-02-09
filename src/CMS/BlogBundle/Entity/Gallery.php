<?php

namespace CMS\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\GalleryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Gallery
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="CMS\BlogBundle\Entity\Carousel", inversedBy="galleries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carousel;

    /**
     * @var UploadedFile
     */
    private $file;

    // on ajoute une mémoire tampon
    private $tempFilename;

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        // Vérification si on a déjà un fichier pour cette entité
        if ($this->url !== null) {
            $this->tempFilename = $this->url;

            // Réinitialisation des ttribut url et alt
            $this->url = null;
            $this->alt = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        // si il n'y a pas de fichier on fait rien
        if ($this->file === null) {
            return;
        }

        // le nom du fichier est son id, on doit juste stocker son extensino
        $this->url = $this->file->guessExtension();

        // on attriut a alt, la valeur du nom de fichier sur le pc de l'util
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * Début fonction upload
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {

        // si pas de fichier on ne fait rien
        if (null === $this->file) {
            return;
        }

        // Si on a un ancien fichier on le supprime
        if ($this->tempFilename !== null) {
            $oldFile = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // On déplace le fichier envoyé dans le répertoire de notre choxi
        $this->file->move(
            $this->getUploadRootDir(),
            $this->id . '.' . $this->url
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
        $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->tempFilename)) {
            // On supprime le fichier
            unlink($this->tempFilename);
        }
    }

    /**
     * Retourne le chemin relatif
     */
    public function getUploadDir()
    {
        return 'uploads/gallery';
    }

    /**
     * Retourne le chemin relatif vers l'image pour notre code php
     */
    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }


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
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Gallery
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Gallery
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set carousel
     *
     * @param \CMS\BlogBundle\Entity\Carousel $carousel
     *
     * @return Gallery
     */
    public function setCarousel(\CMS\BlogBundle\Entity\Carousel $carousel)
    {
        $this->carousel = $carousel;

        return $this;
    }

    /**
     * Get carousel
     *
     * @return \CMS\BlogBundle\Entity\Carousel
     */
    public function getCarousel()
    {
        return $this->carousel;
    }
}
