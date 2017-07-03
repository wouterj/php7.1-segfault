<?php

namespace AppBundle\Security;

use AppBundle\Entity\PortalUser;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $userRepository;

    public function __construct(EntityRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username)
    {
        return $this->userRepository->find($username);
    }

    public function refreshUser(UserInterface $user)
    {
        // Token security is stateless, refreshing shouldn't be executed.
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return PortalUser::class === $class;
    }
}
