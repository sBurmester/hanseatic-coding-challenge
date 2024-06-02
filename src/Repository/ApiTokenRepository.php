<?php

namespace App\Repository;

use App\Entity\ApiToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiToken>
 */
class ApiTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiToken::class);
    }

    public function saveToken(ApiToken $apiToken): void
    {
        $em = $this->getEntityManager();
        $em->persist($apiToken);
        $em->flush();
    }

    public function removeToken(ApiToken $apiToken): void
    {
        $em = $this->getEntityManager();
        $em->remove($apiToken);
        $em->flush();
    }
}
