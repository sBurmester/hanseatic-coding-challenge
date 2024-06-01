<?php

namespace App\Entity;

use App\Repository\ApiTokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\PrePersist;

#[Entity(repositoryClass: ApiTokenRepository::class)]
#[HasLifecycleCallbacks]
class ApiToken
{
    #[Id, GeneratedValue, Column]
    private ?int $id = null;

    #[Column(length: 255)]
    private ?string $token = null;

    #[Column]
    private ?DateTimeImmutable $expiresAt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'apiTokens')]
    #[JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct(User $user, string|null $token)
    {
        $this->user = $user;
        if(null === $token) {
            $this->token = bin2hex(random_bytes(60));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeImmutable $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->expiresAt > new DateTimeImmutable();
    }

    #[PrePersist]
    public function setExpiresAtValue(): void {
        if (null === $this->getExpiresAt()) {
            $this->setExpiresAt(new DateTimeImmutable('+1 week'));
        }
    }
}
