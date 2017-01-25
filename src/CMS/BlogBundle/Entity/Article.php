<?php

namespace CMS\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use CMS\BlogBundle\Validator\Antiflood;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\ArticleRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="title", message="Ceci titre existe déjà, veuillez en choisir un autre")
 */
class Article
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\Length(min=10, minMessage="Le titre doit faire au moins {{ limit }} caractères.")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @Assert\Length(min=2,  minMessage="Le nom d'auteur doit faire au moins {{ limit }} caractères.")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     * @Assert\NotBlank()
     * @Antiflood()
     */
    private $content;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     * @ORM\OneToOne(targetEntity="CMS\BlogBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="CMS\BlogBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     *
     */
    protected $comments;

    /**
     * Article constructor.
     *
     * Par défaut la date de l'annonce est celle du jour
     */
    public
    function __construct()
    {
        $this->date = new \Datetime();
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @Assert\Callback
     */
    public function isContentValid(ExecutionContextInterface $context)
    {
        $forbiddenWords = array('sexe', 'cul');

        // On vérifie que le contenu ne contient pas l'un des mots
        if (preg_match('#' . implode('|', $forbiddenWords) . '#', $this->getContent())) {
            // La règle est violée, on définit l'erreur
            $context
                ->buildViolation('Contenu invalide car il contient un mot interdit.')// message
                ->atPath('content')// attribut de l'objet qui est violé
                ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
            ;
        }
    }

    /**
     * Get content
     *
     * @return string
     */
    public
    function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public
    function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public
    function updateDate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Get id
     *
     * @return int
     */
    public
    function getId()
    {
        return $this->id;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public
    function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public
    function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public
    function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public
    function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public
    function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Article
     */
    public
    function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public
    function getPublished()
    {
        return $this->published;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Article
     */
    public
    function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get image
     *
     * @return \CMS\BlogBundle\Entity\Image
     */
    public
    function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image|null $image
     * @return $this
     */
    public
    function setImage(\CMS\BlogBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param Category $category
     */
    public
    function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * @param Category $category
     */
    public
    function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return ArrayCollection
     */
    public
    function getCategories()
    {
        return $this->categories;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public
    function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Article
     */
    public
    function setUpdatedAt(\Datetime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public
    function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
     */
    public
    function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Add comment
     *
     * @param \CMS\BlogBundle\Entity\Comment $comment
     *
     * @return Article
     */
    public function addComment(\CMS\BlogBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \CMS\BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\CMS\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
