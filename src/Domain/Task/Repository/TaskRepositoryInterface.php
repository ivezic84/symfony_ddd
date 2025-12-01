<?php

namespace App\Domain\Task\Repository;

use App\Domain\Task\Entity\Task;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;
    public function findById(string $id): ?Task;
}
