<?php

namespace AppBundle\Security;

use AppBundle\Entity\PortalUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'code' => JsonResponse::HTTP_UNAUTHORIZED,
            'errors' => [
                ['message' => 'Authentication required'],
            ],
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function getCredentials(Request $request)
    {
        $id = $request->headers->get('X-USR-ID');
        if (null === $id) {
            return null;
        }

        return ['id' => $id];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (!$userProvider instanceof UserProvider) {
            throw new AuthenticationException('Invalid user provider.');
        }

        return $userProvider->loadUserByUsername($credentials['id']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!$user instanceof PortalUser) {
            throw new AuthenticationException('An invalid user object was created.');
        }

        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'code' => JsonResponse::HTTP_FORBIDDEN,
            'errors' => [
                ['message' => strtr($exception->getMessageKey(), $exception->getMessageData())],
            ],
        ], JsonResponse::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
