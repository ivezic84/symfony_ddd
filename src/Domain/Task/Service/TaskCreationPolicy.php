<?php

namespace App\Domain\Task\Service;

class TaskCreationPolicy
{

    public function canCreateTask(int $currentTaskCount): bool
    {
        return $currentTaskCount < 10;
    }

    public function assertCanCreateTask(int $currentTaskCount): void
    {
        if (!$this->canCreateTask($currentTaskCount)) {
            throw new \DomainException("User cannot create more than 10 tasks");
        }
    }

}
