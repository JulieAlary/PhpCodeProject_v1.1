<?php

namespace CMS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use FOS\MessageBundle\Model\ParticipantInterface;


/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CMS\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser implements ParticipantInterface
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    protected $age;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $url;

    /**
     * @ORM\OneToOne(targetEntity="CMS\BlogBundle\Entity\Avatar", cascade={"persist", "remove"})
     */
    protected $avatar;


    public function __construct()
    {
        parent::__construct();

        $this->dateInscription = New \DateTime();
    }


    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return User
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
     * @var \DateTime
     */
    private $dateInscription;


    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return User
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * Set avatar
     *
     * @param \CMS\BlogBundle\Entity\Avatar $avatar
     *
     * @return User
     */
    public function setAvatar(\CMS\BlogBundle\Entity\Avatar $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \CMS\BlogBundle\Entity\Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
