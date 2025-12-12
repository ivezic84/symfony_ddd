<?php

namespace App\Infrastructure\ORM\Task;

use App\Domain\Common\BaseEntity;
use App\Domain\Task\Entity\DomainTask;
use App\Infrastructure\ORM\User\UserEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'task')]
#[ORM\Entity]
class TaskEntity extends BaseEntity
{

    #[ORM\Column(type: 'string', nullable: false)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    private UserEntity $user;


    // Mapping from Domain to Entity
    public static function fromDomain(DomainTask $task, UserEntity $userEntity): self
    {
        $entity = new self();
        $entity->title = $task->getTitle();
        $entity->description = $task->getDescription();
        $entity->user = $userEntity;
        return $entity;
    }


    // Mapping to Domain
    public function toDomain(): DomainTask
    {
        $task = new DomainTask(
            $this->title,
            $this->user->toDomain(),
            $this->description
        );
        $task->setId($this->id);
        return $task;
    }



    // --------- Getteri i Setteri ---------
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    public function setUser(UserEntity $user): void
    {
        $this->user = $user;
    }

}
