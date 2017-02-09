<?php

namespace CMS\BlogBundle\Entity;

use CMS\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\OneToOne(targetEntity="CMS\BlogBundle\Entity\Custom")
     */
    private $custom;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_facebook", type="string", length=255, nullable=true)
     */
    private $faFacebook;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_twitter", type="string", length=255, nullable=true)
     */
    private $faTwitter;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_mail", type="string", length=255, nullable=true)
     */
    private $faMail;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_linkedin", type="string", length=255, nullable=true)
     */
    private $faLinkedin;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_flickr", type="string", length=255, nullable=true)
     */
    private $faFlickr;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_google_plus", type="string", length=255, nullable=true)
     */
    private $faGooglePlus;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_instagram", type="string", length=255, nullable=true)
     */
    private $faInstagram;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_reddit", type="string", length=255, nullable=true)
     */
    private $faReddit;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_pinterest", type="string", length=255, nullable=true)
     */
    private $faPinterest;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_snapchat", type="string", length=255, nullable=true)
     */
    private $faSnapchat;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_soundcloud", type="string", length=255, nullable=true)
     */
    private $faSoundcloud;

    /**
     * @var string
     *
     * @ORM\Column(name="fa_youtube", type="string", length=255, nullable=true)
     */
    private $faYoutube;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="CMS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

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
     * Set faFacebook
     *
     * @param string $faFacebook
     *
     * @return Contact
     */
    public function setFaFacebook($faFacebook)
    {
        $this->faFacebook = $faFacebook;

        return $this;
    }

    /**
     * Get faFacebook
     *
     * @return string
     */
    public function getFaFacebook()
    {
        return $this->faFacebook;
    }

    /**
     * Set faTwitter
     *
     * @param string $faTwitter
     *
     * @return Contact
     */
    public function setFaTwitter($faTwitter)
    {
        $this->faTwitter = $faTwitter;

        return $this;
    }

    /**
     * Get faTwitter
     *
     * @return string
     */
    public function getFaTwitter()
    {
        return $this->faTwitter;
    }

    /**
     * Set faMail
     *
     * @param string $faMail
     *
     * @return Contact
     */
    public function setFaMail($faMail)
    {
        $this->faMail = $faMail;

        return $this;
    }

    /**
     * Get faMail
     *
     * @return string
     */
    public function getFaMail()
    {
        return $this->faMail;
    }

    /**
     * Set faLinkedin
     *
     * @param string $faLinkedin
     *
     * @return Contact
     */
    public function setFaLinkedin($faLinkedin)
    {
        $this->faLinkedin = $faLinkedin;

        return $this;
    }

    /**
     * Get faLinkedin
     *
     * @return string
     */
    public function getFaLinkedin()
    {
        return $this->faLinkedin;
    }

    /**
     * Set faFlickr
     *
     * @param string $faFlickr
     *
     * @return Contact
     */
    public function setFaFlickr($faFlickr)
    {
        $this->faFlickr = $faFlickr;

        return $this;
    }

    /**
     * Get faFlickr
     *
     * @return string
     */
    public function getFaFlickr()
    {
        return $this->faFlickr;
    }

    /**
     * Set faGooglePlus
     *
     * @param string $faGooglePlus
     *
     * @return Contact
     */
    public function setFaGooglePlus($faGooglePlus)
    {
        $this->faGooglePlus = $faGooglePlus;

        return $this;
    }

    /**
     * Get faGooglePlus
     *
     * @return string
     */
    public function getFaGooglePlus()
    {
        return $this->faGooglePlus;
    }

    /**
     * Set faInstagram
     *
     * @param string $faInstagram
     *
     * @return Contact
     */
    public function setFaInstagram($faInstagram)
    {
        $this->faInstagram = $faInstagram;

        return $this;
    }

    /**
     * Get faInstagram
     *
     * @return string
     */
    public function getFaInstagram()
    {
        return $this->faInstagram;
    }

    /**
     * Set faReddit
     *
     * @param string $faReddit
     *
     * @return Contact
     */
    public function setFaReddit($faReddit)
    {
        $this->faReddit = $faReddit;

        return $this;
    }

    /**
     * Get faReddit
     *
     * @return string
     */
    public function getFaReddit()
    {
        return $this->faReddit;
    }

    /**
     * Set faPinterest
     *
     * @param string $faPinterest
     *
     * @return Contact
     */
    public function setFaPinterest($faPinterest)
    {
        $this->faPinterest = $faPinterest;

        return $this;
    }

    /**
     * Get faPinterest
     *
     * @return string
     */
    public function getFaPinterest()
    {
        return $this->faPinterest;
    }

    /**
     * Set faSnapchat
     *
     * @param string $faSnapchat
     *
     * @return Contact
     */
    public function setFaSnapchat($faSnapchat)
    {
        $this->faSnapchat = $faSnapchat;

        return $this;
    }

    /**
     * Get faSnapchat
     *
     * @return string
     */
    public function getFaSnapchat()
    {
        return $this->faSnapchat;
    }

    /**
     * Set faSoundcloud
     *
     * @param string $faSoundcloud
     *
     * @return Contact
     */
    public function setFaSoundcloud($faSoundcloud)
    {
        $this->faSoundcloud = $faSoundcloud;

        return $this;
    }

    /**
     * Get faSoundcloud
     *
     * @return string
     */
    public function getFaSoundcloud()
    {
        return $this->faSoundcloud;
    }

    /**
     * Set faYoutube
     *
     * @param string $faYoutube
     *
     * @return Contact
     */
    public function setFaYoutube($faYoutube)
    {
        $this->faYoutube = $faYoutube;

        return $this;
    }

    /**
     * Get faYoutube
     *
     * @return string
     */
    public function getFaYoutube()
    {
        return $this->faYoutube;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Contact
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set author
     *
     * @param \CMS\UserBundle\Entity\User $author
     *
     * @return Contact
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \CMS\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set custom
     *
     * @param \CMS\BlogBundle\Entity\Custom $custom
     *
     * @return Contact
     */
    public function setCustom(\CMS\BlogBundle\Entity\Custom $custom = null)
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * Get custom
     *
     * @return \CMS\BlogBundle\Entity\Custom
     */
    public function getCustom()
    {
        return $this->custom;
    }
}
