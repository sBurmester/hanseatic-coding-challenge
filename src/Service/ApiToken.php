<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\User as UserEntity;
use App\Repository\ApiTokenRepository;
use App\Entity\ApiToken as ApiTokenEntity;
use DateTimeImmutable;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;

readonly class ApiToken
{
    public function __construct(private ApiTokenRepository $apiTokenRepository)
    {
    }

    public function generateToken(UserEntity $user): string
    {
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $signingKey   = InMemory::plainText(random_bytes(32));
        $now   = new DateTimeImmutable();

        $token = $tokenBuilder
            ->issuedBy($user->getUuid())
            ->relatedTo('api')
            ->identifiedBy($user->getUserIdentifier())
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', $user->getId())
            ->getToken(new Sha256(), $signingKey);

        return $token->toString();
    }

    public function saveToken(User $user, string $token): void
    {
        $apiToken = new ApiTokenEntity($user, $token);
        $this->apiTokenRepository->saveToken($apiToken);
    }
}