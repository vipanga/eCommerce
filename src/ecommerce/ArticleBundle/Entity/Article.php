<?php

namespace ecommerce\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="ecommerce\ArticleBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article {

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
     * @ORM\Column(name="name_item", type="string", length=255)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom de l’article ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le nom de l’article ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $name_item;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 1000000,
     *      minMessage = "Le prix de l’article ne doit pas être moins de {{ limit }}",
     *      maxMessage = "Le prix de l’article ne doit pas dépasser {{ limit }}"
     * )
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     *
     * @Assert\Range(
     *      min = 1,
     *      max = 100000,
     *      minMessage = "La quantité de l’article ne doit pas être moins de {{ limit }}",
     *      maxMessage = "La quantité de l’article ne doit pas dépasser {{ limit }}"
     * )
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="quality", type="string", length=255)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La qualité ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "La qualité ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $quality;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 600,
     *      minMessage = "La description ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "La description ne doit pas avoir plus de {{ limit }} caractères"
     * )
     *
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="solde", type="boolean")
     */
    private $solde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepublication", type="datetime")
     *
     * @Assert\DateTime()
     */
    private $datepublication;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom de la ville ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le nom de la ville ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom de la province ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le nom de la province ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom du pays ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le nom du pays ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $country;

    /**
     * @Gedmo\Slug(fields={"id", "name_item"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="ecommerce\ArticleBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="ecommerce\UserBundle\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ecommerce\ArticleBundle\Entity\Genre", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity="ecommerce\ArticleBundle\Entity\Comment", mappedBy="article", cascade={"persist", "remove"})
     */
    private $comments; // Ici comments prend un « s », car un article a plusieurs comments !

    public function __construct() {
        $this->datepublication = new \DateTime();
        $this->solde = FALSE;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name_item
     *
     * @return string 
     */
    public function getNameItem()
    {
        return $this->name_item;
    }

    /**
     * Set name_item
     *
     * @param string $nameItem
     * @return Article
     */
    public function setNameItem($nameItem)
    {
        $this->name_item = $nameItem;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Article
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quality
     *
     * @return string 
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Set quality
     *
     * @param string $quality
     * @return Article
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get solde
     *
     * @return boolean 
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set solde
     *
     * @param boolean $solde
     * @return Article
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get datepublication
     *
     * @return \DateTime 
     */
    public function getDatepublication()
    {
        return $this->datepublication;
    }

    /**
     * Set datepublication
     *
     * @param \DateTime $datepublication
     * @return Article
     */
    public function setDatepublication($datepublication)
    {
        $this->datepublication = $datepublication;

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
     * Set city
     *
     * @param string $city
     * @return Article
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get province
     *
     * @return string 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set province
     *
     * @param string $province
     * @return Article
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Article
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get image
     *
     * @return \ecommerce\ArticleBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param \ecommerce\ArticleBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\ecommerce\ArticleBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ecommerce\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \ecommerce\UserBundle\Entity\User $user
     * @return Article
     */
    public function setUser(\ecommerce\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \ecommerce\ArticleBundle\Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set genre
     *
     * @param \ecommerce\ArticleBundle\Entity\Genre $genre
     * @return Article
     */
    public function setGenre(\ecommerce\ArticleBundle\Entity\Genre $genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Add comments
     *
     * @param \ecommerce\ArticleBundle\Entity\Comment $comments
     * @return Article
     */
    public function addComment(\ecommerce\ArticleBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \ecommerce\ArticleBundle\Entity\Comment $comments
     */
    public function removeComment(\ecommerce\ArticleBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
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
