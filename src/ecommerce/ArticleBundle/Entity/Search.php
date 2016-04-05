<?php

namespace ecommerce\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Search
 *
 * @ORM\Table(name="search")
 * @ORM\Entity(repositoryClass="ecommerce\ArticleBundle\Repository\SearchRepository")
 */
class Search
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
     * @ORM\Column(name="item", type="string", length=255)
     */
    private $item;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *
     * @Assert\DateTime()
     */
    private $date;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Get item
     *
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set item
     *
     * @param string $item
     * @return Search
     */
    public function setItem($item)
    {
        $this->item = $item;

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
     * @return Search
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}
