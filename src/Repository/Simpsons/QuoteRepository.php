<?php

namespace App\Repository\Simpsons;

use App\Entity\Simpsons\Quote;
use Doctrine\ORM\EntityManagerInterface;

readonly class QuoteRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return array|Quote[]
     */
    public function getQuotes(null|string $orderDirection): array
    {
        if (null !== $orderDirection && !in_array($orderDirection, ['ASC', 'DESC'],  true)) {
            throw new \InvalidArgumentException('$orderedByAddedDate can only be null or ASC/DESC');
        }

        $quotes = $this->entityManager->getRepository(Quote::class);

        if (null === $orderDirection) {
            return $quotes->findAll();
        }

        return $quotes->findBy([], ['addedDate' => $orderDirection]);
    }

    public function addQuote(Quote $quote): void
    {
        $this->entityManager->persist($quote);
    }

    public function removeQuote(Quote $quote): void
    {
        $this->entityManager->remove($quote);
    }
}