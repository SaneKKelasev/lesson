<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class ApiTokenAuthenticator implements AccessTokenHandlerInterface
{
    public function __construct(
        private ApiTokenRepository $tokenRepository
    )
    {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        $token = $this->tokenRepository->findOneBy(['token' => $accessToken]);

        if ($token === null || $token->isExpired()) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        return new UserBadge($token->getUser()->getEmail());
    }
}
