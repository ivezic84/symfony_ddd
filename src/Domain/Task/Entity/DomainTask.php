<?php

namespace App\Domain\Task\Entity;

use App\Domain\User\Entity\DomainUser;

class DomainTask
{

    private ?int $id = null;
    private string $title;
    private ?string $description;
    private DomainUser $user;

    public function __construct(string $title, DomainUser $user, ?string $description = null)
    {
        $this->title = $title;
        $this->user = $user;
        $this->description = $description;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getUser(): DomainUser
    {
        return $this->user;
    }

    public function setUser(DomainUser $user): void
    {
        $this->user = $user;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

}
