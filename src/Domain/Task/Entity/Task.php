<?php

namespace App\Domain\Task\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Infrastructure\Task\Repository\DoctrineTaskRepository')]
#[ORM\Table(name: 'tasks')]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'boolean')]
    private bool $completed = false;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function complete(): void
    {
        $this->completed = true;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
