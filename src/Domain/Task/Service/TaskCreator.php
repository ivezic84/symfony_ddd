<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Entity\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;

class TaskCreator
{

    public function __construct(private TaskRepositoryInterface $repository)
    {
    }

    public function create(string $title): Task
    {
        $task = new Task($title);
        $this->repository->save($task);

        return $task;
    }

}
