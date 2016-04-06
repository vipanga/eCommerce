<?php

namespace ecommerce\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Review
 *
 * @ORM\Table(name="review")
 * @ORM\Entity(repositoryClass="ecommerce\ArticleBundle\Repository\ReviewRepository")
 */
class Review
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
     * @ORM\ManyToOne(targetEntity="ecommerce\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 600,
     *      minMessage = "Le contenu ne doit pas avoir moins de {{ limit }} caractères",
     *      maxMessage = "Le contenu ne doit pas avoir plus de {{ limit }} caractères"
     * )
     */
    private $content;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     *
     * @Assert\Range(
     *      min = 0.5,
     *      max = 5,
     *      minMessage = "La note ne doit pas être moins de {{ limit }}",
     *      maxMessage = "La note ne doit pas dépasser {{ limit }}"
     * )
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="ecommerce\UserBundle\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Rating
     */
    public function setContent($content)
    {
        $this->content = $content;

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
     * @return Rating
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Rating
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get author
     *
     * @return \ecommerce\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set author
     *
     * @param \ecommerce\UserBundle\Entity\User $author
     * @return Rating
     */
    public function setAuthor(\ecommerce\UserBundle\Entity\User $author)
    {
        $this->author = $author;

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
     * @return Rating
     */
    public function setUser(\ecommerce\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }
}
