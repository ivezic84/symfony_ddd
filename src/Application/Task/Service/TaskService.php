<?php

namespace App\Application\Task\Service;

use App\Application\Task\DTO\TaskDTO;
use App\Domain\Task\Entity\DomainTask;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class TaskService
{

    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private UserRepositoryInterface $userRepository
    ) {}


    public function createTask(TaskDTO $taskDTO): DomainTask
    {
        $userEntity = $this->userRepository->getEntityById($taskDTO->userId);
        if (!$userEntity) {
            throw new \Exception("User not found");
        }

        // domain user za domain task
        $domainUser = $userEntity->toDomain();

        $task = new DomainTask(
            title: $taskDTO->title,
            user: $domainUser,
            description: $taskDTO->description
        );

        $this->taskRepository->save($task, $userEntity);

        return $task;
    }


    public function updateTask(DomainTask $task, TaskDTO $taskDTO): void
    {
        $task->setTitle($taskDTO->title);
        $task->setDescription($taskDTO->description ?? null);


        if (isset($taskDTO->userId)) {
            $user = $this->userRepository->findById($taskDTO->userId);
            if (!$user) {
                throw new \Exception("User not found");
            }
            $task->setUser($user);
        }

        $this->taskRepository->save($task);
    }


    public function deleteTask(DomainTask $task): void
    {
        $this->taskRepository->delete($task);
    }

}
