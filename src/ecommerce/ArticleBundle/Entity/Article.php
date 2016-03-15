<?php

namespace ecommerce\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="ecommerce\ArticleBundle\Repository\ArticleRepository")
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="vendu", type="boolean")
     */
    private $vendu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepublication", type="datetime")
     */
    private $datepublication;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;


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
     * Set nom
     *
     * @param string $nom
     * @return Article
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
     * Set prix
     *
     * @param float $prix
     * @return Article
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Article
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set etat
     *
     * @param string $etat
     * @return Article
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
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
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set vendu
     *
     * @param boolean $vendu
     * @return Article
     */
    public function setVendu($vendu)
    {
        $this->vendu = $vendu;

        return $this;
    }

    /**
     * Get vendu
     *
     * @return boolean 
     */
    public function getVendu()
    {
        return $this->vendu;
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
     * Get datepublication
     *
     * @return \DateTime 
     */
    public function getDatepublication()
    {
        return $this->datepublication;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Article
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Article
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }
}
