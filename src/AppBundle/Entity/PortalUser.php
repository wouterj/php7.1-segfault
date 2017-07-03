<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class PortalUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group")
     */
    private $group;

    public function __construct($id, Group $group)
    {
        $this->id = $id;
        $this->group = $group;
    }

    /** @return Group */
    public function getGroup()
    {
        return $this->group;
    }

    public function getUsername()
    {
        return $this->id;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials() {}
    public function getPassword() {}
    public function getSalt() {}
}
