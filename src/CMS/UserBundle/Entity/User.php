<?php

namespace CMS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CMS\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var UploadedFile
     */
    private $file;

    // on ajoute une mémoire tampon
    private $tempFilename;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
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
            $this->getUploadRootDir()
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
        $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id;
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
        return 'uploads/avatar';
    }

    /**
     * Retourne le chemin relatif vers l'image pour notre code php
     */
    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
}
