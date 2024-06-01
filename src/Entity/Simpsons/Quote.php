<?php

namespace App\Entity\Simpsons;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\PrePersist;

#[Entity]
#[Index(name: "added_date_idx", columns: ["added_date"])]
#[HasLifecycleCallbacks]
class Quote
{
    #[Id, GeneratedValue ,Column(name: 'quote_id', type: 'integer', length: 150)]
    public int|null $id = null;
    #[Column(name: 'quote_hash', type: 'string', length: 255)]
    public string $quoteHash;
    #[Column(name: 'quote', type: 'string')]
    public string $quote;
    #[Column(name: 'added_date', type: 'datetime_immutable')]
    public \DateTimeImmutable|null $addedDate = null;

    public function __construct(string $quote)
    {
        $this->quote = $quote;
        $this->quoteHash = sha1($quote);
    }

    public function getQuoteHash(): string
    {
        return $this->quoteHash;
    }

    public function getQuote(): string
    {
        return $this->quote;
    }

    public function getAddedDate(): ?\DateTimeImmutable
    {
        return $this->addedDate;
    }

    #[PrePersist]
    public function setAddedDateValue(): void {
        if (null === $this->addedDate) {
            $this->addedDate = new \DateTimeImmutable();
        }
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function toJson(): string
    {
        return  json_encode($this, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    }
}