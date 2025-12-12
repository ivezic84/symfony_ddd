<?php

namespace App\Infrastructure\ORM\Task;

use App\Domain\Task\Entity\DomainTask;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Infrastructure\ORM\User\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function save(DomainTask $task, UserEntity $userEntity): void
    {
        $entity = TaskEntity::fromDomain($task, $userEntity);
        $this->em->persist($entity);
        $this->em->flush();

        $task->setId($entity->getId());
    }

    public function delete(DomainTask $task): void
    {
        $entity = $this->em->getRepository(TaskEntity::class)->find($task->getId());
        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
        }
    }

    public function findById(int $id): ?DomainTask
    {
        $entity = $this->em->getRepository(TaskEntity::class)->find($id);
        return $entity?->toDomain();
    }

    public function findTasksByUser(UserEntity $userEntity): array
    {
        $entities = $this->em->getRepository(TaskEntity::class)->findBy(['user' => $userEntity]);
        return array_map(fn(TaskEntity $e) => $e->toDomain(), $entities);
    }

}
