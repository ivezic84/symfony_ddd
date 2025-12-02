<?php

namespace App\Domain\Task\Repository;

use App\Domain\Task\Entity\DomainTask;
use App\Infrastructure\ORM\User\UserEntity;

interface TaskRepositoryInterface
{
    public function save(DomainTask $task, UserEntity $userEntity): void;
    public function delete(DomainTask $task): void;
}
