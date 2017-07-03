<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", unique=true)
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Article", mappedBy="group")
     * @ORM\JoinTable(name="article_vehicles",
     *     joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $articles;

    public function __construct($id, $name)
    {
        $this->articles = new ArrayCollection();
        $this->id = $id;
        $this->name = $name;
    }

    /** @return string */
    public function getId()
    {
        return $this->id;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    public function add(Article $vehicle)
    {
        $this->articles->add($vehicle);
    }

    public function getArticles()
    {
        return $this->articles->toArray();
    }
}
