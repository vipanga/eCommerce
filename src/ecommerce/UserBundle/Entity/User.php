<?php

// src/ecommerce/UserBundle/Entity/User.php

namespace ecommerce\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ecommerce\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le prénom ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le nom ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      minMessage = "Le sexe ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le sexe ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      min = 9,
     *      max = 15,
     *      minMessage = "Le numéro de téléphone ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le numéro de téléphone ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      min = 3,
     *      max = 40,
     *      minMessage = "L'url ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "L'url ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="address", type="text", nullable=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 600,
     *      minMessage = "L'adresse ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "L'adresse ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $address;

    /**
     * @var \DateTime
     * @ORM\Column(name="birth_date", type="datetime", nullable=true)
     */
    private $birth_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    private $note;
    
    /**
     * @ORM\OneToOne(targetEntity="ecommerce\ArticleBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;
    
    /**
     * @ORM\OneToMany(targetEntity="ecommerce\ArticleBundle\Entity\Article", mappedBy="user", cascade={"persist", "remove"})
     */
    private $articles; // Ici articles prend un « s », car un user a plusieurs articles !

    /**
     * @ORM\OneToMany(targetEntity="ecommerce\ArticleBundle\Entity\Review", mappedBy="user")
     */
    private $reviews; // Ici review prend un « s », car un user a plusieurs reviews !

    /**
     * @ORM\OneToMany(targetEntity="ecommerce\ArticleBundle\Entity\Cart", mappedBy="user", cascade={"persist", "remove"})
     */
    private $carts; // Ici carts prend un « s », car un user a plusieurs carts !

    public function __construct() {
        parent::__construct();

        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->note = 0;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return User
     */
    public function setWebsite($website)
    {
        $this->website = $website;

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
     * @return User
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
     * @return User
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get birth_date
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * Set birth_date
     *
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get note
     *
     * @return float 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set note
     *
     * @param float $note
     * @return User
     */
    public function setNote($note)
    {
        $this->note = $note;

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
     * @return User
     */
    public function setImage(\ecommerce\ArticleBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Add articles
     *
     * @param \ecommerce\ArticleBundle\Entity\Article $articles
     * @return User
     */
    public function addArticle(\ecommerce\ArticleBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \ecommerce\ArticleBundle\Entity\Article $articles
     */
    public function removeArticle(\ecommerce\ArticleBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add reviews
     *
     * @param \ecommerce\ArticleBundle\Entity\Review $reviews
     * @return User
     */
    public function addReview(\ecommerce\ArticleBundle\Entity\Review $reviews)
    {
        $this->reviews[] = $reviews;

        return $this;
    }

    /**
     * Remove reviews
     *
     * @param \ecommerce\ArticleBundle\Entity\Review $reviews
     */
    public function removeReview(\ecommerce\ArticleBundle\Entity\Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Add carts
     *
     * @param \ecommerce\ArticleBundle\Entity\Cart $carts
     * @return User
     */
    public function addCart(\ecommerce\ArticleBundle\Entity\Cart $carts)
    {
        $this->carts[] = $carts;

        return $this;
    }

    /**
     * Remove carts
     *
     * @param \ecommerce\ArticleBundle\Entity\Cart $carts
     */
    public function removeCart(\ecommerce\ArticleBundle\Entity\Cart $carts)
    {
        $this->carts->removeElement($carts);
    }

    /**
     * Get carts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarts()
    {
        return $this->carts;
    }
}
