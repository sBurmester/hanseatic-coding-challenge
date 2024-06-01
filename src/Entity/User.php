<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class User
{
    #[Id, GeneratedValue, Column(name: 'quote_id', type: 'integer')]
    public int|null $id = null;

    #[Column(name: 'username', type: 'string', length: 255)]
    public string $username;

    #[Column(name: 'password', type: 'string')]
    public string $password;

    #[Column(name: 'created_at', type: 'datetime_immutable')]
    public DateTimeImmutable $createdAt;
}